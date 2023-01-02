<?php
require_once  MODEL_BASE_PATH."Database.php"; 
class  LoginModel extends Database
{ 
    function __construct(){
        $this->db = new Database();
        $this->crudModel = new CrudModel();
        $this->table = $this->crudModel->getPageTableName("dealeruser");
        
    }    

    public function verifyLogin($values,$condtion)
    {         
        session_start();  
        $sqlQuery = "SELECT * FROM `".$this->table."` ".$condtion; 
        $result = $this->db->executeQuery($sqlQuery);  
        if(!empty($result[0])){ 
                $_SESSION['gps-dealer']["UserName"]=$values['UserName'];   
                $_SESSION['gps-dealer']["loggedIn"]=1;   
                $_SESSION['gps-dealer']["DealerUserID"]=$result[0]['DealerUserID'];
  
                
                         
            return(json_encode(array("Status"=>1,"Message"=>"Login Success")));
        }
        else {
              return(json_encode(array("Status"=>0,"Message"=>"Login failed")));
        }
    }
    
}

?>