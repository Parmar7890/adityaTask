<?php
class Database
{

  private $con;

  public function connection()
  {
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $db = "db_auth";

    try {

      return $this->con = new PDO("mysql:host=$server_name;dbname=$db", $username, $password);
      //echo "connection successfuly";

    } catch (PDOException $e) {
      echo $e;
    }
  }
}

?>