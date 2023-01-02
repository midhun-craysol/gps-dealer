<?php
require_once  MODEL_BASE_PATH."Database.php";
session_start();    
class UserBaseController extends BaseController
{
    public function __construct(){
        $this->db = new Database();
    }
}

 ?>