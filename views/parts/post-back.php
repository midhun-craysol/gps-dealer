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
}


?>