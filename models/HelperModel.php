<?php
require_once  MODEL_BASE_PATH."Database.php"; 
require_once  MODEL_BASE_PATH."CrudModel.php"; 
 
class HelperModel extends Database
{
    function __construct(){ 
        $this->db = new Database();
        $this->crudModel = new CrudModel();
        $this->projectTable = $this->crudModel->getPageTableName("project_m");
        $this->projectstruct = $this->crudModel->getPageTableName("projectstruct_m");
        $this->projectstructDet = $this->crudModel->getPageTableName("projectstruct_det");

    }
public function InputStringFormat($InputText){
      return $this->db->htmlRealEscapeString($InputText);
}

public function getSearch($condition)
{
      $sqlQuery = "SELECT `VehID`,`VehRegNum` FROM ".$this->vehicleTable." ".$condition; 
      $result = $this->db->executeQuery($sqlQuery); 
      return($result);
}

public function nameByID($table,$ID,$Name)
{   

    $tablename=$this->crudModel->getPageTableName($table);
   // echo $table;
    $sqlQuery = "SELECT ".$ID.",".$Name." FROM ".$tablename." WHERE Status = '1'";
    // echo $sqlQuery;
    // die();
    $result = $this->db->executeQuery($sqlQuery);
    if(!empty($result)){            
          return(json_encode(array("qry"=>$result, "Status"=>1,"data"=>$result,"Message"=>"List fetched successfully")));
    }
    else {
          return(json_encode(array("qry"=>$result, "Status"=>0,"Message"=>"List fetching Failed")));
    }
}
public function nameByIDWithSearch($table,$ID,$Name,$Searchvalue,$Searchitem)
{

    $tablename=$this->crudModel->getPageTableName($table);
    $sqlQuery = "SELECT ".$ID.",".$Name." FROM ".$tablename." WHERE Status = '1' AND `".$Searchitem."`='".$Searchvalue."'";
    $result = $this->db->executeQuery($sqlQuery);
    if(!empty($result)){            
          return(json_encode(array("Status"=>1,"data"=>$result,"Message"=>"List fetched successfully")));
    }
    else {
          return(json_encode(array("Status"=>0,"Message"=>"List fetching failed")));
    }
}
public function LoadActiveProjects($condition)
{
    $sqlQuery = "SELECT `ProjectID`,`ProjectName` FROM `".$this->projectTable."`" .$condition;
    $result = $this->db->executeQuery($sqlQuery);
    if(!empty($result)){            
          return(json_encode(array("Status"=>1,"data"=>$result,"Message"=>"List fetched successfully")));
    }
    else {
          return(json_encode(array("Status"=>0,"Message"=>"List fetching failed")));
    }
}
public function LoadActiveProjectsWithSt()
{
    $sqlQuery = " SELECT `Pjt`.`ProjectID`,`Pjt`.`ProjectName` ,`pStruct`.`ProjectStructID`FROM `".$this->projectTable."` as`Pjt` ";
    $sqlQuery .= " INNER JOIN `".$this->projectstruct."` AS `pStruct` 
    ON (`Pjt`.`ProjectID` =  `pStruct` .`ProjectID` AND  `Pjt`.`Status` = '1')"; 
    $sqlQuery .= " INNER JOIN `".$this->projectstructDet."` AS `pStructDet` 
    ON (`pStructDet`.`ProjectStructID` =  `pStruct` .`ProjectStructID`)"; 
    $sqlQuery .= " GROUP BY `Pjt`.`ProjectID` ";
    $result = $this->db->executeQuery($sqlQuery);
    if(!empty($result)){            
          return(json_encode(array("Status"=>1,"data"=>$result,"Message"=>"List fetched successfully")));
    }
    else {
          return(json_encode(array("Status"=>0,"Message"=>"List fetching failed")));
    }
}
    
public function LoadProjectStructure($condition)
{

    $sqlQuery = "SELECT `ProjectStructID` FROM `".$this->projectstruct."`"  .$condition." LIMIT 1";
    $result = $this->db->executeQuery($sqlQuery);
    if(!empty($result)){            
          return(json_encode(array("Status"=>1,"StID"=>$result[0]['ProjectStructID'],"Message"=>"List fetched successfully")));
    }
    else {
          return(json_encode(array("Status"=>0,"Message"=>"List fetching failed")));
    }
}

public function loadprojectStructureDetail($condition)
{

    $sqlQuery = "SELECT `ProjectStructID`,`StartDateTime` as `ProjectStructName` FROM  `".$this->projectstruct."`"  .$condition;
   
    $result = $this->db->executeQuery($sqlQuery);
    if(!empty($result)){            
          return(json_encode(array("Status"=>1,"data"=>$result,"Message"=>"List fetched successfully")));
    }
    else {
          return(json_encode(array("Status"=>0,"Message"=>"List fetching failed")));
    }
}

}
