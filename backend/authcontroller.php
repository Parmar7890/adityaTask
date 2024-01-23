<?php
require("../database/db.php");
class Authcontroller{

    private $conn;

    public function __construct(){
        $obj = new Database();
        $this->conn = $obj->connection();
    }
    function insert_user($data) {
 $response = [];
        try {

            $sql = "SELECT id FROM tbl_user WHERE email=:email";
           
            $query  = $this->conn->prepare($sql);
            $query->bindParam(':email', $data[3]['value']);
            $query ->execute();
            $result = $query->fetchColumn();
           
            if($result > 0){
                
                // echo "<pre>";
                // print_r($result);
                // echo "email is same";
                $response["status"] = 200;
                $response["message"] = "this email is allready register";
            }  
                else{
                $stmt = $this->conn->prepare("INSERT INTO tbl_user (full_name, phone, email, password) VALUES(:full_name, :phone, :email, :password)");
                $full_name = $data[0]['value'].'-' .$data[1]['value'];
        $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':phone', $data[2]['value']);
            $stmt->bindParam(':email', $data[3]['value']);
          $stmt->bindParam(':password', $data[4]['value']);
        $stmt->execute();
               $response["status"] = 200;
               $response["message"]  = "user register successfully";  
            }
            // die;
            // echo "<pre>";
            // print_r($data);
           
        } catch (PDOException $e) {
            // echo "Error: " . $e->getMessage();
       $response["status"] = 404;
  $response["message"] = "user not register";
        }
        echo json_encode($response);
             return $response;
    }


    
    function select(){
       
        $query = $this->conn->prepare("SELECT * FROM tbl_user");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    
    }
    



    function updateData($data) {
        // echo "<pre>";
        // echo "new";
         print_r($data);
        
        $response = [];
               try {
       
                   $sql = "UPDATE tbl_user SET full_name=:full_name,phone=:phone,email=:email,status=:status WHERE id=:id";
                  
                //    $query  = $this->conn->prepare($sql);
                //    $query->bindParam(':email', $data[3]['value']);
                //    $query ->execute();
                //    $result = $query->fetchColumn();
                  
                //    if($result > 0){
                       
                //        // echo "<pre>";
                //        // print_r($result);
                //        // echo "email is same";
                //        $response["status"] = 200;
                //        $response["message"] = "this email is allready register";
                //    }  
                    //    else{
                    //    $stmt = $this->conn->prepare("INSERT INTO tbl_user (full_name, phone, email, status) VALUES(:full_name, :phone, :email, :status)");
                       
                    //    $full_name = $data[""].'-' .$data[1]['value'];
                    $stmt=$this->conn->prepare($sql);
                    $stmt->bindParam(':id',$data["id"]);
               $stmt->bindParam(':full_name', $data["full_name"]);
                   $stmt->bindParam(':phone', $data['phone']);
                   $stmt->bindParam(':email', $data['email']);
                 $stmt->bindParam(':status', $data['status']);
               $stmt->execute();
                      $response["status"] = 200;
                      $response["message"]  = "user update successfully";  
                //    }
                   // die;
                   // echo "<pre>";
                   // print_r($data);
                  
               } catch (PDOException $e) {
                   // echo "Error: " . $e->getMessage();
              $response["status"] = 404;
         $response["message"] = "user not update";
               }
               echo json_encode($response);
                    return $response;
           }
       
       


}
$frmData = json_decode(file_get_contents("php://input"), true);
// echo "<pre>";
// print_r($frmData);
if($frmData["action"] == "registernew")
{

    $user_registration = new Authcontroller();
    $result = $user_registration->insert_user($frmData['data']);
}

if($frmData["action"] == "select"){
    $obj = new Authcontroller();
    echo $obj->select();
}


if($frmData["action"] == "updateRow"){
    // echo "<pre>";
    // var_dump($frmData);
    // die;
    $obj = new Authcontroller();
     $obj->updateData($frmData["data"]);
}





