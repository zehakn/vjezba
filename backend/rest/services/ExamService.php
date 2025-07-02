<?php
require_once __DIR__."/../dao/ExamDao.php";

class ExamService {
    protected $dao;

    public function __construct(){
        $this->dao = new ExamDao();
    }

    /** TODO
    * Implement service method to get all customers
    */
    public function get_customers(){
        return $this->dao->get_customers();
    }

    /** TODO
    * Implement service method to get all customer meals
    */
    public function get_customer_meals($customer_id){
        return $this->dao->get_customer_meals($customer_id);

    }

    /** TODO
    * Implement service method to add customer to the database
    */
    public function add_customer($customer){
        return $this->dao->add_customer($customer);
    }

    /** TODO
    * Implement service method to return detailed list of foods
    * and total of nutrients for each food
    */
    public function foods_report(){
        return $this->dao->get_foods_report();
    }

    public function delete_customer($customer_id){
        /** TODO
        * Implement service method to delete customer from the database
        */
        return $this->dao->delete_customer($customer_id);
    }

    public function update_customer($customer_id, $data){
        /** TODO
        * Implement service method to update customer in the database
        */
        return $this->dao->update_customer($customer_id, $data);
    }


    

    public function register_user($data) {
        if(!$data['email'] || !$data['password']) {
            throw new Exception("missing fields");
        }

        return $this->dao->register_user($data['email'], $data['password']);
    }

    public function login_user($data) {
        $user = $this->dao->get_user_by_email($data['email']);
        if (!$user || !password_verify($data['password'], $user['password'])) {
            throw new Exception("invalid email or password");
        }

        unset($user['password']);
        return $user;
    }
}

?>
