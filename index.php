<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('PROJECT_ROOT_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
require __DIR__ . "/inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

//Defining allowed routes 
if ((isset($uri[3]) && array_key_exists($uri[3],$routes))) {
    $route = preg_split("#/#", $routes[$uri[3]]); 
   
    if(!empty($route) && $route[0]!='' && $route[1] !=''){        
        $fileName = ($route[2]!='')?__DIR__."/controllers/".$route[0]."/".$route[1]."Controller.php":__DIR__."/controllers/".$route[0]."Controller.php";
        define("CURRENT_ROUTE",$uri[3]);
        if(file_exists($fileName)){
            require($fileName);
            $controller = ($route[2]!='')?$route[1]."Controller":$route[0]."Controller";
            $objFeedController = new $controller();
            $strMethodName = ($route[2]!='')?$route[2].'Action':$route[1].'Action';
            $objFeedController->{$strMethodName}();
            // echo("here".$controller."---".$strMethodName);
            
        }
        else{     
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }
    else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }

}
else {
    header("HTTP/1.1 404 Not Found");
    exit();
}
 //test comment
?>