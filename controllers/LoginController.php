<?php
require_once  MODEL_PATH."system/LoginModel.php";
class LoginController extends BaseController
{  
    public function __construct(){
        $this->crudModel = new CrudModel();
        $this->loginModel = new LoginModel();
        $tableName = $this->crudModel->getPageTableName("dealeruser");
        $this->table = ($tableName != '')? $tableName:'';
    }

    public function loginAction(){     
        $this->loadView("login/header");   
        $this->loadView("login/login"); 
        $scripts = ["system/login","system/dashboard"];  
        $this->loadView("login/footer",$scripts);   
    }

    public function verifyLoginAction(){       
        
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if($requestMethod != 'POST'){                    
            $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));
        } else {                    
            $errors = [];
            //Required fields                    
            $fields = ["LoginUserID","LoginPswd"]; 
            $optionalFields = [];
            $values = [];
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
               
                
                if(!empty($errors)){      
                    $responseData = json_encode(array("Status"=>0,"Message"=>"Please enter all fields","fields"=>$errors)); 
                } 
                else {  
                        $table = "dealeruser";  
                        $condition = " WHERE BINARY `LoginUserID`='".$_POST['UserName']."' AND `LoginPswd` = '".md5($_POST['LoginPswd'])."' AND Status='1' ";

                        
                        $responseData = $this->loginModel->verifyLogin($_POST,$condition);
                }
              

                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            }
        }  

    }
}

?>