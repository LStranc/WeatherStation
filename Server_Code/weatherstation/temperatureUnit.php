<?php 
    require('RetrieveValues.php');
    $recentValues = new RetrieveValues; 


    $newUnit = $_POST['newUnit'];

    if($newUnit == 1){
        echo ($recentValues->getTemperatureF() . "&#176;F");									
    }
    else{
        echo ($recentValues->getTemperatureC() . "&#176;C");									
    }
?>