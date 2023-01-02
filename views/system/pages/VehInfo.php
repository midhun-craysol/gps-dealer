<?php
post_back('VehInfo'); 
foreach(['VehID','SrNumber'] as $el){
  (isset($_POST[$el])? $$el =  $_POST[$el]:$$el='');
}
//   echo $_POST[''];
//   echo $_POST[''];
//   echo $_POST[''];
unset($_POST);
?>

<html>

</html>