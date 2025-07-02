var CustomersService = {
    getCustomers: callback => RestClient.get('/customers', callback),
    getMeal: (id, callback) => RestClient.get(`/customer/meals/` + id, callback),
    add: (data, callback) => RestClient.post('/customers/add', data, callback),
};

$(document).ready(function () {
    function loadCustomers() {
        CustomersService.getCustomers( customers => {
            let options = '<option selected>Please select one customer</option>';
            customers.forEach(customer => {
                options += `<option value="${customer.id}">${customer.first_name} ${customer.last_name}</option>`;
            });
            $('#customers-list').html(options);
        });
    }

    loadCustomers();

    $('#customers-list').on("change", function () {
        const id = $(this).val();
        if(!id || id === "Please select one customer") return;

        CustomersService.getMeal(id, meals => {
            let rows = "";
            meals.forEach(m => {
                rows += `<tr><td>${m.food_name}</td><td>${m.food_brand}</td><td>${m.meal_date}</td></tr>`;
            });
            $("#customer-meals tbody").html(rows);
        });
    });

    $("#add-customer-modal form").on("submit", function (e) {
        e.preventDefault();
        const data = {
            first_name: $("first_name").val(),
            last_name: $("last_name").val(),
            birth_date: $("birth_date").val(),
        };
        CustomersService.add(data, () => {
            loadCustomers();
            this.reset();
            $("#add-customer-modal").modal("hide");
            toastr.success("Customer added successfully");
        });
    });
});