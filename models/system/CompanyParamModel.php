<?php
require_once  MODEL_BASE_PATH."Database.php"; 
class  CompanyParamModel extends Database
{ 
    function __construct(){
        $this->db = new Database();
        $this->crudModel = new CrudModel();
        $this->table = $this->crudModel->getPageTableName("compparam");
        
    }    

    public function paginate( $searchValue,$columnsToSearch,$sortColumn,$sortOrder,$draw,$row,$rowperpage){
        ## Total number of records without filtering
        $selQ = "SELECT count(*) as allcount FROM `".$this->table."`";
        
        $totalRecords = (!empty($sel))? $sel[0]['allcount']:0;
        $searchQuery = " ";
        
        if(!empty($columnsToSearch) && ($totalRecords != 0)){
            if($searchValue != ''){
                $searchQuery .= " and ( ";                
                foreach ($columnsToSearch as $key=> $column) { 
                    // echo("Key ".$key);
                    $searchQuery .= $column." like '%".$searchValue."%' ";                
                    // echo("count ".count($columnsToSearch));

                    if((count($columnsToSearch)-1) != $key){                    
                        $searchQuery .=" or ";
                    }else {
                        $searchQuery .=") ";
                    }
                    
                }
             }
        }
         ## Total number of record with filtering
        
         $sel = $this->db->select("select count(*) as allcount from ".$this->table." ".$searchQuery);
         $totalRecordwithFilter = (!empty($sel))? $sel[0]['allcount']:0;
         $query ="SELECT `".$this->table."`.*  FROM `".$this->table."`";
         $resultRecords =  $this->db->select( $query);
         
        
        $data = array();
        foreach ($resultRecords as $key => $row) {
            $actions ='<button type="button" class="btn  btn-icon" onclick="editCompParam('.$row['SampleParam'].')"><i class="bi bi-pencil" title="Edit"></i></button>' ;
            $data[] = array( 
                "SampleParam"=>$row['SampleParam'],
                'Actions' => $actions
            );
        }
         //print_r($data);
            ##Response
        $response = array(
              "draw" => intval($draw),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecordwithFilter,
              "aaData" => $data
        );

        return($response);

    }

}