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
    //load Projects
    public function LoadProjectsAction()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if($requestMethod != 'POST'){    
            $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));
        }
        else
        {               
            $condition = " WHERE `Status` = '1' ";
            if(!empty($_POST['ProjectID']))
            {
                $condition .= " AND `ProjectID` = '".$_POST['ProjectID']."' ";
            }
            $responseData = $this->helperModel->LoadActiveProjects($condition); 
            $this->sendOutput($responseData,array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
    }
    //load Projects WIth ST
    public function LoadProjectsWithSTAction()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if($requestMethod != 'POST'){    
            $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));
        }
        else
        {     
            $responseData = $this->helperModel->LoadActiveProjectsWithSt(); 
            $this->sendOutput($responseData,array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
    }

    //load Structures
    public function loadprojectStructureAction()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if($requestMethod != 'POST'){    
            $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));
        }
        else
        {               
            $condition = " WHERE `EndDateTime` IS NULL ";
            if(!empty($_POST['ProjectID']))
                {
                    $condition .= " AND `ProjectID` = '".$_POST['ProjectID']."' ";
                }
            $responseData = $this->helperModel->LoadProjectStructure($condition); 
            $this->sendOutput($responseData,array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        
    }

    public function loadprojectStructureDetailAction()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if($requestMethod != 'POST'){    
            $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));
        }
        else
        {  
            
            if(!empty($_POST['ProjectStructID']))
                {
                    $condition = " WHERE `ProjectStructID` = '".$_POST['ProjectStructID']."' ";
                }
            $responseData = $this->helperModel->loadprojectStructureDetail($condition); 
            $this->sendOutput($responseData,array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        
    }
    public function loadStructureDetailsByPjtAction()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if($requestMethod != 'POST'){    
            $this->sendOutput('', array('HTTP/1.1 400 Bad Request'));
        }
        else
        {  
            
            if(!empty($_POST['ProjectID']))
                {
                    $condition = " WHERE `ProjectID` = '".$_POST['ProjectID']."' AND `EndDateTime` IS NULL ";
                }
            $responseData = $this->helperModel->loadprojectStructureDetail($condition); 
            $this->sendOutput($responseData,array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        
    }

	


	public function executeVahanQuery($vahanConn , $query = "" , $params = [])
    {
        
        try {
            $stmt = $vahanConn->prepare( $query );
 
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
 
            if( $params ) {
                $stmt->bind_param($params[0], $params[1]);
            }
 
            $stmt->execute();
 
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }   
    }




    public function vehMfgNameAction()
    {
    	$responseData = $this->helperModel->listvehMfgName();
    	$this->sendOutput(
                        $responseData,
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                    );  
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