<?php 
    require('RetrieveValues.php');
    $recentValues = new RetrieveValues; 


    $newUnit = $_POST['newUnit'];

    if($newUnit == 1){
        echo ($recentValues->getHeatIndexF() . "&#176;F");									
    }
    else{
        echo ($recentValues->getHeatIndexC() . "&#176;C");									
    }
?>