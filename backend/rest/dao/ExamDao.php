<?php

class ExamDao {

    private $conn;

    /**
     * constructor of dao class
     */
    public function __construct(){
        try {
          /** TODO
           * List parameters such as servername, username, password, schema. Make sure to use appropriate port
           */
          $host = 'localhost';
           $port = '3306';
           $db = 'webfinal';
           $user = 'root';
           $password = '';
           

         /*$ssl_ca = '/path/to/ca-cert.pem';




          /** TODO
           * Create new connection
           */
          $this->conn = new PDO(
              "mysql:host=" . $host . ";dbname=" . $db . ";port=" . $port,
              $user,
              $password,
              [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                //PDO::MYSQL_ATTR_SSL_CA => $ssl_ca - Use only if SSL is required
              ]
           );

          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    /** TODO
     * Implement DAO method used to get customer information
     */
    public function get_customers(){
      $stmt = $this->conn->prepare("SELECT * FROM customers");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    /** TODO
     * Implement DAO method used to get customer meals
     */
    public function get_customer_meals($customer_id) {

      $stmt = $this->conn->prepare("SELECT f.name as food_name,
                                          f.brand as food_brand,
                                          m.created_at as meal_date
                                   FROM meals m
                                   JOIN foods f ON m.food_id = f.id
                                   WHERE m.customer_id = :customer_id");

      $stmt->execute(['customer_id' => $customer_id]);
      return $stmt->fetchAll();
    }

    /** TODO
     * Implement DAO method used to save customer data
     */
    public function add_customer($data){
      $stmt = $this->conn->prepare("
      INSERT INTO customers (first_name, last_name, birth_date)
      VALUES (:first_name, :last_name, :birth_date)
      ");

      $stmt->execute([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'birth_date' => $data['birth_date']
      ]);

      $data['id'] = $this->conn->lastInsertId();
      return $data;
    }


    /** TODO
     * Implement DAO method used to get foods report
     */
    public function get_foods_report(){
      $stmt = $this->conn->prepare("
      SELECT f.name,
             f.brand,
             CONCAT('<img src=\"', f.image_url, '\" width=\"100\"/>') AS image,
            (SELECT quantity FROM food_nutrients fn JOIN nutrients n ON fn.nutrient_id = n.id WHERE fn.food_id = f.id AND n.name = 'Energy' LIMIT 1) AS energy,
            (SELECT quantity FROM food_nutrients fn JOIN nutrients n ON fn.nutrient_id = n.id WHERE fn.food_id = f.id AND n.name = 'Protein' LIMIT 1) AS protein,
            (SELECT quantity FROM food_nutrients fn JOIN nutrients n ON fn.nutrient_id = n.id WHERE fn.food_id = f.id AND n.name = 'Fat' LIMIT 1) AS fat,
            (SELECT quantity FROM food_nutrients fn JOIN nutrients n ON fn.nutrient_id = n.id WHERE fn.food_id = f.id AND n.name = 'Fiber' LIMIT 1) AS fiber,
            (SELECT quantity FROM food_nutrients fn JOIN nutrients n ON fn.nutrient_id = n.id WHERE fn.food_id = f.id AND n.name = 'Carb' LIMIT 1) AS carbs
      FROM foods f
      LIMIT 50
     ");

     $stmt->execute();
     return $stmt->fetchAll();
    

    }

    /** TODO
     * Implement DAO method used to delete customer
     */

    public function delete_customer($customer_id){
      $stmt = $this->conn->prepare("DELETE FROM customers WHERE id = :customer_id");
      $stmt->execute(['customer_id' => $customer_id]);
      
    } 

    /** TODO
     * Implement DAO method used to update customer data
     */
    
    public function update_customer($customer_id, $data){
      $stmt = $this->conn->prepare("
      UPDATE customers 
      SET first_name = :first_name, last_name = :last_name, birth_date = :birth_date
      WHERE id = :customer_id
      ");

      $stmt->execute([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'birth_date' => $data['birth_date'],
        'customer_id' => $customer_id
      ]);

      return $data;
    }

    /** TODO
     * Implement DAO method used to register a new user
     */

     public function register_user($email, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");

        $stmt->execute([
          ':email' => $email,
          ':password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
        
        return $this->conn->lastInsertId();
     }

    /** TODO
     * Implement DAO method used to retreive user by email
     */

     public function get_user_by_email($email) {
      $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
      $stmt->execute([':email' => $email]);

      return $stmt->fetch(PDO::FETCH_ASSOC);
     }

    /** TODO
     * close connection
     */
    public function close_connection() {
        $this->conn = null;
    }
}
?>
