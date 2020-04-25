<?php


class Database{

  // specify your own database credentials
  private $host = "localhost";
  private $db_name = "my_blog";
  private $username = "tom";
  private $password = "123";
  private $conn;

  // get the database connection
  public function connect(){

      $this->conn = null;
        //new PDO object to pass in DB info
      try{
          //takes in DSN (database type) and db name, username, password
          $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch(PDOException $exception){
          echo "Connection error: " . $exception->getMessage();
      }

      return $this->conn;
  }
}