<?php 
function post_back($PageName){
    if(!empty($_POST)){
            foreach($_POST as $PostIndexes => $PostVal){
                $_SESSION['postSession'][$PageName][$PostIndexes] = $PostVal;
            }
            }
            else if(isset($_SESSION['postSession']['VehInfo'])){
                foreach($_SESSION['postSession'][$PageName] as $PostIndexes => $PostVal){
                    $_POST[$PostIndexes] = $PostVal;
                }
        }
        // $_POST['ClientID']   = $_SESSION['ClientID'];  
        // $_POST['MobAppID']   = $_SESSION['MobAppID']; 
        // $_POST['ClientName'] = $_SESSION['ClientName'];
        // $_POST['UserName']   = $_SESSION['UserName'];
}


?>