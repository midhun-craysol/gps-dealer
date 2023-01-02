<?php
require_once  MODEL_PATH."system/CompanyParamModel.php"; 
require_once  MODEL_PATH."system/CompanyParamModel.php";
require_once  MODEL_PATH."HelperModel.php";
class CompanyParamController extends UserBaseController
{  
  
    public function __construct(){
        $this->db = new Database();
        $this->crudModel = new CrudModel();
        $this->companyparamModel = new CompanyParamModel();
        $this->helperModel = new HelperModel();
        $this->table = $this->crudModel->getPageTableName("param");
        
    }
    
    
    public function companyparamAction()
    {
        $dbname = DB_DATABASE_NAME;
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$dbname."' AND TABLE_NAME = '".$this->table."'";
        $resultRecords =  $this->db->select($query);
        $result= [];
        foreach ($resultRecords as $key => $row) {
          $result[] = $row;
        }    
        if(!empty($result)){ 
            // Array of all column names
            $var['columnArr'] = array_column($result, 'COLUMN_NAME');
            $var['paramRows'] =  $this->db->select( "select `".$this->table."`.* from `".$this->table."`"); 
        
        }                  
        $data['breadhome'] = 'General';
        $data['breadpage'] = 'Company Parameters';
        if( $_SERVER["REQUEST_METHOD"] == 'POST' && $_POST['dAccess'] =="dashboard" )
        {
            $this->loadView("system/pages/company_param",[],$var);
            $data["scripts"] = ["system/companyparam","lib/form_helper"]; 
            $this->loadView("parts/plain",[],$data);
        } 
        else{ 
            $this->loadView("parts/header",[],$data);
            $this->loadView("parts/sidebar");
            $this->loadView("system/pages/company_param",[],$var);
            $scripts = ["system/companyparam","lib/form_helper"];     
            $this->loadView("parts/footer",$scripts,$data);             
          } 
    }

    public function updateAction()
    {        
        $requestMethod = $_SERVER["REQUEST_METHOD"];
         
        if($requestMethod != 'POST'){   
            $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));
        }
        else
        {                    
            $values = [];
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                // $textParams = ["SalesTaxRegCode","CompName","StateName","CompAbbr","MaxDealerLevel","CompITRegCode","CompAddress","FileUploadRootFolder"];
                $textParams = ["SampleParam"];
                
                $values = [];
                
                if(!empty($_POST)){
                    foreach($_POST as $key => $input){
                        if(in_array($key,$textParams)){
                            $values[$key] = $input;
                        }
                        
                    }     
                    if(!empty($values)){
                        $responseData = $this->crudModel->update($this->table,$values,"");
                        $this->sendOutput(
                            $responseData,
                            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                        );
                    } 
                    else{
                        $this->sendOutput(
                            json_encode(array("Status"=>0,"Message"=>"Update Failed","val"=>$values)),
                            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                        );
                    }
                }   
                else{
                    $this->sendOutput(
                        json_encode(array("Status"=>0,"Message"=>"Update Failed","post"=>$_POST)),
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                    );
                }
            }
        }
            
    }
    

}