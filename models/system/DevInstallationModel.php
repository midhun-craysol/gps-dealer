<?php 
require_once  MODEL_BASE_PATH."Database.php";
require_once  MODEL_BASE_PATH."CrudModel.php"; 
class  DevInstallationModel extends Database
{
    function __construct(){
        $this->crudModel = new CrudModel();
        $this->db = new Database();
        $this->DevInstallationTable = $this->crudModel->getPageTableName("dev_installation_log");
        $this->vehicleTable = $this->crudModel->getPageTableName("veh_m");
        $this->dealerTable = $this->crudModel->getPageTableName("dealer_m");
        $this->deviceTable = $this->crudModel->getPageTableName("device_m");
        $this->deviceModelTable = $this->crudModel->getPageTableName("devicemodel_m");         
        $this->ais140_activation = $this->crudModel->getPageTableName("ais140_activation"); 
    }
    public function details($table,$conditions)
    {
        $sqlQuery = "SELECT `".$table."`.*, `".$this->countryTable."`.`CountryName` FROM `".$table."` ";   
        $sqlQuery .= " INNER JOIN `".$this->countryTable."` ON `".$table."`.`CountryID`=`".$this->countryTable."`.`CountryID` ";     
        $sqlQuery .= ($conditions)?(" ".$conditions):" ";
        $sqlQuery .= " LIMIT 1";        
        $result = $this->db->executeQuery($sqlQuery);
        if(!empty($result)){            
              return(json_encode(array("Status"=>1,"data"=>$result[0],"Message"=>"Details fetched successfully")));
        }
        else {
              return(json_encode(array("Status"=>0,"Message"=>"Details fetching failed")));
        }
    }
    
    public function editDevInstalation($DevInstallationLogID)
    {
        $query ="SELECT `".$this->DevInstallationTable."`.*,`".$this->vehicleTable."`.`VehRegNum`,`".$this->deviceTable."`.`DeviceSrNumber` FROM `".$this->DevInstallationTable."`";
        $query .=" JOIN `".$this->vehicleTable."` ON `".$this->vehicleTable."`.`VehID` = `".$this->DevInstallationTable."`.`VehID` ";
        $query .=" LEFT JOIN `".$this->deviceTable."` ON `".$this->deviceTable."`.`DeviceID` = `".$this->DevInstallationTable."`.`DeviceID` "; 
        $query .=" WHERE `".$this->DevInstallationTable."`.`Status`!='2' AND `".$this->DevInstallationTable."`.`DevInstallationLogID` = '".$DevInstallationLogID."'"; 
        $result = $this->db->executeQuery($query);
        if(!empty($result)){            
              return(json_encode(array("Status"=>1,"data"=>$result[0],"Message"=>"Details fetched successfully")));
        }
        else {
              return(json_encode(array("Status"=>0,"Message"=>"Details fetching failed")));
        }
    }
    public function paginate($searchValue,$columnsToSearch,$sortColumn,$sortOrder,$draw,$row,$rowperpage)
    {
        $word = "-"; 
        $serchval= $searchValue;
        if(strpos($serchval, $word) !== false){
        
                $searchValue1=explode("-",$serchval);
                foreach($searchValue1 as $serc){     
                $searchValue2="-".$searchValue1[0];
                if($searchValue1[1] !=""){
                
                    if(strlen($searchValue1[1])=="2"){
                    $searchValue3="-".$searchValue1[1];
                    }else{
                    $searchValue3="";
                    } 
                } 
                if($searchValue1[2] !=""){
                    
                    if(strlen($searchValue1[2])=="4"){
                    $searchValue4=$searchValue1[2];
                    }else{
                    $searchValue4="";
                    }
                
                }
                
                }
                $searchValue= $searchValue4.$searchValue3.$searchValue2;
                
            }

            
        ## Total number of records without filtering 
        $selQ = "SELECT count(*) as allcount FROM `".$this->DevInstallationTable."` ";
        $selQ .= " WHERE `".$this->DevInstallationTable."`.`Status`!='2' ";
        $sel =  $this->db->select($selQ);
        $totalRecords = (!empty($sel))? $sel[0]['allcount']:0;
        $searchQuery = "";
        
        if(!empty($columnsToSearch) && ($totalRecords != 0)){
            if($searchValue != ''){
                $searchQuery = " and ( ";    
                if(stripos("Active", $searchValue) !==false ){                    
                    $searchQuery .= $this->DevInstallationTable.".Status like '%1%' or ";
                } 
                if(stripos("Inactive", $searchValue) !==false ){                    
                    $searchQuery .= $this->DevInstallationTable.".Status like '%0%' or ";
                }              
                foreach ($columnsToSearch as $key=> $column) { 
                    $searchQuery .= $column." like '%".$searchValue."%' ";    

                    if((count($columnsToSearch)-1) != $key){                    
                        $searchQuery .=" or ";
                    }else {
                        $searchQuery .=") ";
                    }
                    
                }
             }
        }
        if($sortColumn == "Status"){
            $sort ="";
          }
          else{
            $sort = " `".$this->customerTable."`.Status DESC , ";
          }

        $sel2 = $this->db->select($selQ." ".$searchQuery);
        $totalRecordwithFilter = (!empty($sel2))? $sel2[0]['allcount']:0;
        session_start();
        $query ="SELECT `".$this->ais140_activation."`.`ActivationID`,`".$this->ais140_activation."`.`AccountStatus`, `".$this->ais140_activation."`.`VehAccountStatus`,  `".$this->DevInstallationTable."`.*,`".$this->vehicleTable."`.`VehRegNum`,`".$this->dealerTable."`.`DealerName`,`".$this->deviceTable."`.`DeviceSrNumber` FROM `".$this->DevInstallationTable."`";
        $query .=" JOIN `".$this->vehicleTable."` ON `".$this->vehicleTable."`.`VehID` = `".$this->DevInstallationTable."`.`VehID` ";
        $query .=" JOIN `".$this->dealerTable."` ON `".$this->dealerTable."`.`DealerID` = `".$this->DevInstallationTable."`.`InstallDealerID` ";
        $query .=" JOIN `".$this->deviceTable."` ON `".$this->deviceTable."`.`DeviceID` = `".$this->DevInstallationTable."`.`DeviceID` "; 
        $query .=" LEFT JOIN `".$this->ais140_activation."` ON `".$this->DevInstallationTable."`.`DevInstallationLogID` = `".$this->ais140_activation."`.`DevInstallationLogID` "; 
        $query .=" WHERE `".$this->DevInstallationTable."`.`Status`!='2' AND `".$this->DevInstallationTable."`.`InstallDealerID` ='".$_SESSION['dealerapp']['DealerMainID']."'  ";
         
        $resultRecords =  $this->db->select( $query);
        
        $data = array();
        foreach ($resultRecords as $key => $row) {

             if($row['Status']==1){
                $Status='Active';
                $colorclass='';
            }
            else{
                $colorclass='colorrow';
                $Status='Inactive';
            }
            $activated = ($row['ActivationID'] !='')?1:0;
            $activateType = ($row['AccountStatus'] =='Temporary')?'t':'p';
            $expired = ($row['VehAccountStatus'] !='Active')?1:0;
            $tbutton= ''; //.$activated."---".$activateType."--".$expired;
            // if(($activated==1 && $activateType =='t' && $expired ==0) || ($activated==0) )
            if($activated==0)
            {
                $tbutton ='<button type="button" class="btn btn-sm btn-success  btn-sm" onclick="tempActReinstate(\''.$row['DevInstallationLogID'].'\')">Temp. Activate</button>';
            }
            $actions = $tbutton.'<button type="button" class="btn btn-sm btn-icon  btn-sm" onclick="viewDevInstallation(\''.$row['DevInstallationLogID'].'\')"><i class="fa fa-eye" title="View"></i></button>';
            $actions .='<button type="button" onclick="delDevInstallation(\''.$row['DevInstallationLogID'].'\')" class="btn  btn-sm btn-icon  btn-sm delCrBtn"><i class="fa fa-trash" title="Delete"></i></button>' ;
           
           
            $data[] = array( 
                "DevInstallationLogID"=>$key+1,
                "VehID"=>$row['VehRegNum'],
                "InstallDate"=>$row['InstallDate'], 
                "DeviceID"=>$row['DeviceSrNumber'],
                "Status" => $Status,
                'Actions' => $actions,
                'ExtraPadding' => "&nbsp",
            );
        }

        $response = array(
              "draw" => intval($draw),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecordwithFilter,
              "aaData" => $data,
        );

        return($response);

    }
}
?>