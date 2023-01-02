<?php

    require_once  MODEL_BASE_PATH."Database.php"; 
    require_once  MODEL_BASE_PATH."CrudModel.php"; 

    class UserModel extends Database
    {
      function __construct(){ 
            $this->db = new Database();
            $this->crudModel = new CrudModel();
            $this->UsersTable =  $this->crudModel->getPageTableName("users");
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
        $selQ = "SELECT count(*) as allcount FROM `".$this->UsersTable."`";

        $selQ .=" WHERE (".$this->UsersTable.".Status !='2')";

        $sel =  $this->db->select($selQ);
        $totalRecords = (!empty($sel))? $sel[0]['allcount']:0;
        $searchQuery = "";
        
        if(!empty($columnsToSearch) && ($totalRecords != 0)){
            if($searchValue != ''){
                $searchQuery .= " and ( ";    
                if(stripos("Active",$searchValue) !== false)
                {
                    $searchQuery.="`".$this->UsersTable."`.`Status` like '%1%' or ";
                } 
                if(stripos("Inactive",$searchValue) !== false)
                {
                    $searchQuery.="`".$this->UsersTable."`.`Status` like '%0%' or ";
                }
                if(stripos("Active",$searchValue) !== false)
                {
                    $searchQuery.="`".$this->UsersTable."`.`RootFlg` like '%1%' or ";
                } 
                if(stripos("Inactive",$searchValue) !== false)
                {
                    $searchQuery.="`".$this->UsersTable."`.`RootFlg` like '%0%' or ";
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
        $query ="SELECT * FROM `".$this->UsersTable."`";
        $query .=" WHERE ( `".$this->UsersTable."`.`Status` !='2' )";
        $query .= " ".$searchQuery." order by ".$sortColumn." ".$sortOrder." limit ".$row.",".$rowperpage;
        $resultRecords =  $this->db->select( $query);
        $data = array();
        foreach ($resultRecords as $key => $row) {
            $actions ="<button class='btn  btn-icon' onclick='editUser(\"".$row["UserID"]."\")'><i class='bi bi-pencil' title='edit'></i></button>
            <button class='btn  btn-icon' onclick='delUser(\"".$row["UserID"]."\")'>
            <i class='bi bi-trash' title='delete'></i></button>";
            
            if($row['RootFlg']=="1"){$RootFlg='Active';}
            else{$RootFlg='Inactive';}

            if($row['Status']=="1"){$Status='Active';}
            else{$Status='Inactive';}
            //root user action hide
            if($row['RootFlg']=="1" && $row['UserID']=="1236563256897456321235" && $row['UserName']=="admin"){
                $actions ="";
            }
            $data[] = array( 
                "UserID"=>$key+1,
                "UserName"=>$row['UserName'],
                "CreatedAt"=>date('d-m-Y',strtotime($row['CreatedAt'])),
                "RootFlg"=>$RootFlg,
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