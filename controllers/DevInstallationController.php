<?php
require_once  MODEL_PATH."system/DevInstallationModel.php";
require_once  MODEL_PATH."HelperModel.php";
class DevInstallationController extends UserBaseController
{  
    public function __construct(){

        $this->crudModel = new CrudModel();
        $this->DevInstallationModel = new DevInstallationModel();
        $this->helperModel = new HelperModel();
        $tableName = $this->crudModel->getPageTableName("dev_installation_log");
        $this->countryTable = $this->crudModel->getPageTableName("country");
        $this->stateTable = $this->crudModel->getPageTableName("state"); 
        $this->table = ($tableName != '')? $tableName:'';
        $this->dealerStockTable = $this->crudModel->getPageTableName("dealerstock");
        
    }
    public function devInstallationLogAction()
    {
        
        $timeStart = microtime(true);   
        $data['timeStart'] =  microtime(true); 
       
        if( $_SERVER["REQUEST_METHOD"] == 'POST' && $_POST['dAccess'] =="dashboard" )
        { 
       
        $this->loadView("system/pages/dev_installation_Form");
        $data["scripts"] = ["system/devinstallation","helper/table","helper/form"];  
        $this->loadView("parts/plain",$data);  
       }
        else{            
            header("HTTP/1.1 404 Not Found");
            exit();
        }  
    
        }

   
    public function loadTableAction()
    { 
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; 
            $columnIndex = $_POST['order'][0]['column']; 
            $columnName = $_POST['columns'][$columnIndex]['data']; 
            $columnSortOrder = $_POST['order'][0]['dir'];         
            $searchValue = $_POST['search']['value']; // Search value
            $searchColumns =[$_POST['searchColumn']]; 
            $page=$this->DevInstallationModel->paginate($searchValue,$searchColumns,$columnName,$columnSortOrder,$draw,$row,$rowperpage);
            echo(json_encode($page));
    } 
    

    public function detailsAction()
        { 
      
            
        $requestMethod = $_SERVER["REQUEST_METHOD"];
         
                if($requestMethod != 'POST'){                    

                    $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));

                }
                else
                {        
                    $errors = [];                   
                    $fields = ['DevInstallationLogID']; 
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
                            $conditions= " WHERE `".$this->table."`.`DevInstallationLogID` = '".$values['DevInstallationLogID']."'";  
                            $responseData = $this->crudModel->details($this->table,$conditions);

                            $this->sendOutput($responseData,array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                            );
                            
                        }
                }
            }        
       
        
    }

    public function deleteAction()
        {      
            session_start();
            $requestMethod = $_SERVER["REQUEST_METHOD"];
         
                if($requestMethod != 'POST'){                    

                    $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));

                }
                else
                {                    
                   $errors = [];
                   $fields = ['DevInstallationLogID'];                    
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

                            $whereCondition =" WHERE DevInstallationLogID = '".$values['DevInstallationLogID']."' ";
                            $stockDelCondition = "  WHERE  `DealerID`='".$_SESSION['gps-dealer']['DealerMainID']."' AND   `DevInstallationLogID`='".$values['DevInstallationLogID']."' "; 
                            $stockUpdate= $this->crudModel->updateRow($this->dealerStockTable,['DevInstallationLogID'=>''],$stockDelCondition);
 
                            $responseData = $this->crudModel->deleteStatus($this->table,$whereCondition);
                            echo json_encode($responseData);
                         }
                }
            }
        }


    public function createAction()
        {                 
          
        
                $requestMethod = $_SERVER["REQUEST_METHOD"];       
 
                if($requestMethod != 'POST'){                   

                    $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));

                }
                else
                {           
                   
                    $errors = [];
                    $fields = ["VehID","DeviceSr","OdoCorrectionConf"]; 
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
                        
                       
                        $values["Status"] = 1;                     
                       
                        if(!empty($errors)){
                            $this->sendOutput(
                                json_encode(array("Status"=>0,"Message"=>"Please enter all fields","fields"=>$errors)),
                                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                            );
                        }
                        else{
                            
                            $condition1 = " WHERE DeviceID = '".$values['DeviceID']."' AND Status !='2' ";
                            $duplicates1 = $this->crudModel->checkDuplicates($this->table,$condition1); 
                            if($duplicates1===true) {
                                
                                    $this->sendOutput(
                                    json_encode(array("Status"=>2,"Message"=>"Detail already exists")),
                                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                                    );
                                
                            }  else {
                                    $values['DeviceID'] = $this->validateDevice($values['DeviceSr']); 
                                    $values['InstallDealerID'] = $_SESSION['gps-dealer']['DealerMainID'];
                                    if($values['DeviceID'] !=0){
                                        unset($values['DeviceSr']); 
                                        $installID = $this->crudModel->createRow($this->table,$values);
                                        if(!empty($installID)){                                            
		                                    $dlrStock =  $this->crudModel->getPageTableName("dealerstock");
                                            $stockCondition = " WHERE `DeviceID` ='".$values['DeviceID']."' AND `DealerID` ='".$values['InstallDealerID']."' ";
                                            $stockUpdate= $this->crudModel->updateRow($dlrStock,['DevInstallationLogID'=>$installID],$stockCondition);
                                            
		                                    $actTbl =  $this->crudModel->getPageTableName("ais140_activation");
                                            $tempActVlues = [
                                                 "VehID" => $values['VehID'],
                                                 "AccountStatus" => "Temporary",
                                                 "DevInstallationLogID" => $installID,
                                                
                                            ];
                                            $tempAct = $this->crudModel->add($actTbl,$tempActVlues);
                                            $this->sendOutput(
                                                $tempAct,
                                                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                                            );
                                        }
                                        else{
                                            $this->sendOutput(
                                                json_encode(array("Status"=>0,"Message"=>"Installation Error")),
                                                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                                                );
                                        }
                                   
                                    
                                }
                                else{
                                    $this->sendOutput(
                                        json_encode(array("Status"=>2,"Message"=>"Invalid Device SerialNumber")),
                                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                                        );
                                }
                               
                            }                      
                            
                        }
                }
            }
          
    }

    public function validateDevice($DeviceSrNumber)
    { 
		$devTbl =  $this->crudModel->getPageTableName("device_m");
		$dlrStock =  $this->crudModel->getPageTableName("dealerstock");
        $DlrID =  $_SESSION['gps-dealer']['DealerMainID'];
        $sqry  = " SELECT  `dev_m`.`DeviceID` FROM `".$devTbl."` as `dev_m` ";
        $sqry .= " JOIN `".$dlrStock."` as `dlrStk` ON  (`dlrStk`.`DeviceID` = `dev_m`.`DeviceID` )";
        $sqry .= " WHERE `DeviceSrNumber` = '".$DeviceSrNumber."' AND `dlrStk`.`DealerID`='".$DlrID."' AND `dlrStk`.`LockedForMove`='0' AND `dlrStk`.`DevInstallationLogID`='' LIMIT 1";
        $responseData = $this->helperModel->getDevSelect($sqry);
        if(!empty($responseData)){
            return($responseData[0]['DeviceID']);
        }
        else{
            return(0);
        }
    }
    public function editDetailsAction()
    { 
       
            $responseData = $this->DevInstallationModel->editDevInstalation($_POST['DevInstallationLogID']);
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
            
       
    }
   
 }