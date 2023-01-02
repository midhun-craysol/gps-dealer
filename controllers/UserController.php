<?php
require_once  MODEL_PATH."system/UserModel.php";
require_once  MODEL_PATH."HelperModel.php";
class UserController extends UserBaseController
{  
    public function __construct(){
        $this->helperModel = new HelperModel();
        $this->crudModel = new CrudModel();
        $this->UserModel = new UserModel();
        $tableName = $this->crudModel->getPageTableName("user_m");
        $this->table = ($tableName != '')? $tableName:'';          
    }
    public function dashboardAction(){ 
        
        $this->loadView("parts/header");
        $this->loadView("parts/sidebar");
        $data['breadhome'] = 'General';
        $data['breadpage'] = 'Dashboard';
        $this->loadView("parts/dashboard");
        $this->loadView("parts/footer");
    }

    public function logoutAction(){
        unset($_SESSION['dealerapp']);            
    }
    public function SamplepageAction(){ 
            $this->loadView("parts/header");
            $this->loadView("forms/user");
            $this->loadView("parts/footer");

    }

    public function pwdUpdateAction()
        {
           
           
            $requestMethod = $_SERVER["REQUEST_METHOD"];
 
            if($requestMethod != 'POST'){
                $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));
            }
            else
            {                    
                $errors = [];
                $fields = ["UserID","Pswd"]; 
                $optionalFields = [];
                $values = [];
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    foreach ($fields as $field) {
                        if (empty($_POST[$field]) && !in_array($field, $optionalFields)) {
                            $errors[] = $field;
                        } else {
                            $values[$field] = $this->helperModel->InputStringFormat($_POST[$field]);
                            
                        }
                    }
                   
                  
                   
                    if(!empty($errors)){
                        $this->sendOutput(
                            json_encode(array("Status"=>0,"Message"=>"Please enter all fields","fields"=>$errors)),
                            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                        );
                    }
                    else{      
                           $whereCondition ="WHERE UserID ='".$values['UserID']."'";
                           $values['Pswd']=md5($values['Pswd']);
                           $values['RestFlag']="1";
                            $responseData = $this->crudModel->update($this->table,$values,$whereCondition);
                            $this->sendOutput(
                                $responseData,
                                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                            );
                       
                    }
            }
        }

        }



   
 }