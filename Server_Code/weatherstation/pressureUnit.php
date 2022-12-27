<?php 
    require('RetrieveValues.php');
    $recentValues = new RetrieveValues; 


    $newUnit = $_POST['newUnit'];

    if($newUnit == 1){
        echo ($recentValues->getPressureMbar() . " mb");									
    }
    else{
        echo ($recentValues->getPressureMmhg() . " Mmhg");									
    }
?>