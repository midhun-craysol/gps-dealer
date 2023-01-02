<?php

    require_once  MODEL_BASE_PATH."Database.php"; 
    require_once  MODEL_BASE_PATH."CrudModel.php"; 

    class UserModel extends Database
    {
      function __construct(){ 
            $this->db = new Database();
            $this->crudModel = new CrudModel();
            $this->table =  $this->crudModel->getPageTableName("user_m");
      }


      public function paginate( $searchValue,$columnsToSearch,$sortColumn,$sortOrder,$draw,$row,$rowperpage)
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
        $selQ = "SELECT count(*) as allcount FROM `".$this->table."`";

        $selQ .=" WHERE (".$this->table.".Status !='2')";

        $sel =  $this->db->select($selQ);
        $totalRecords = (!empty($sel))? $sel[0]['allcount']:0;
        $searchQuery = "";
        
        if(!empty($columnsToSearch) && ($totalRecords != 0)){
            if($searchValue != ''){
                $searchQuery .= " and ( ";    
                if(stripos("Active",$searchValue) !== false)
                {
                    $searchQuery.="`".$this->table."`.`Status` like '%1%' or ";
                } 
                if(stripos("Inactive",$searchValue) !== false)
                {
                    $searchQuery.="`".$this->table."`.`Status` like '%0%' or ";
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
        ## Total number of record with filtering 
        $sel2 = $this->db->select($selQ." ".$searchQuery);
        $totalRecordwithFilter = (!empty($sel2))? $sel2[0]['allcount']:0;
        $query ="SELECT * FROM `".$this->table."`";
        $query .=" WHERE ( `".$this->table."`.`Status` !='2' )";
        $query .= " ".$searchQuery." order by ".$sortColumn." ".$sortOrder." limit ".$row.",".$rowperpage;
        $resultRecords =  $this->db->select( $query);
        $data = array();
        foreach ($resultRecords as $key => $row) {
            
            $actions ="<button class='btn  btn-icon' onclick='editUser(\"".$row["UserID"]."\")'><i class='bi bi-pencil' title='edit'></i></button>";
           
            if($_SESSION['gps-dealer']["LoginID"]!=$row['LoginID'])
            {
                $actions .="<button class='btn  btn-icon' onclick='delUser(\"".$row["UserID"]."\")'>
                <i class='bi bi-trash' title='delete'></i></button>";
               
            }
            $actions .="<button class='btn  btn-icon' onclick='resetPwd(\"".$row["UserID"]."\")'>
            <i class='bi bi-lock-fill'></i></button>";
            
            if($row['RootFlg']=="1"){$RootFlg='Active';}
            else{$RootFlg='Inactive';}

            if($row['Status']=="1"){$Status='Active';}
            else{$Status='Inactive';}
           
            $data[] = array( 
                "UserID"=>$key+1,
                "UserName"=>$row['UserName'],               
                "LoginID"=>$row['LoginID'],
                "UserType"=>$row['UserType'],
                "Status"=>$Status,
                'Actions' => $actions
            );
        }
        $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
        );

        return($response);
  
        }
  
    }
?>