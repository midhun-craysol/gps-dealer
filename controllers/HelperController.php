<?php
require_once  MODEL_PATH."HelperModel.php";
class HelperController extends UserBaseController
{
    public function __construct(){
        $this->crudModel = new CrudModel();
        $this->helperModel = new HelperModel();       
    }

    public function nameByIDAction()
    {
    	if(isset($_POST['ID']) && isset($_POST['Names']) && isset($_POST['TabName'])){
    		$ID=$_POST['ID'];
    		$Name=$_POST['Names'];
    		$TableName=$_POST['TabName'];

	    	$responseData = $this->helperModel->nameByID($TableName,$ID,$Name);
	    	$this->sendOutput(
	            $responseData,
	            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
	        );  
    	}
    	
    }

   
    public function nameByIDWithSearchAction()
    {
    	if(isset($_POST['ID']) && isset($_POST['Names']) && isset($_POST['TabName'])){
    		$ID=$_POST['ID'];
    		$Name=$_POST['Names'];
    		$TableName=$_POST['TabName'];
    		$Searchvalue=$_POST['Searchvalue'];
    		$Searchitem=$_POST['Searchitem'];

	    	$responseData = $this->helperModel->nameByIDWithSearch($TableName,$ID,$Name,$Searchvalue,$Searchitem);
	    	$this->sendOutput(
	            $responseData,
	            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
	        );  
    	}
    	
    }

    public function getSearchAction()
	{
		$vehRegNum = $_POST['veh_reg_num'];
		if(isset($vehRegNum)){
			$condition = "WHERE `VehRegNum` LIKE '%".$vehRegNum."%' AND `Status`!='2' ORDER BY `VehRegNum` ASC ";
			$responseData = $this->helperModel->getSearch($condition);
			$search_array = array();
			foreach($responseData as $fetch)
			{
				$id = $fetch['VehID'];
				$vehRegNum = $fetch['VehRegNum'];
				$search_array[] = array("VehID" => $id,"VehRegNum" => $vehRegNum);

			}
		}
		
		echo json_encode($search_array);
	}
   
    
}