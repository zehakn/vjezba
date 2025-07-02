var FoodsService = {
  getAll: callback => RestClient.get('/foods/report', callback)
};

$(document).ready(function () {
  FoodsService.getAll(function (foods) {
    let rows = "";

    foods.forEach(function (food) {
      rows += `
        <tr>
          <td>${food.name}</td>
          <td>${food.brand}</td>
          <td class="text-center">${food.image}</td>
          <td>${food.energy ?? "-"}</td>
          <td>${food.protein ?? "-"}</td>
          <td>${food.fat ?? "-"}</td>
          <td>${food.fiber ?? "-"}</td>
          <td>${food.carbs ?? "-"}</td>
        </tr>
      `;
    });

    $("table tbody").html(rows);
  });
});