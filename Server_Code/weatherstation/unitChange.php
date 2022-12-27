<?php 
    require('RetrieveValues.php');
    $recentValues = new RetrieveValues; 


    $newUnit = $_POST['newUnit'];
    $condition = $_POST['condition'];

    if ($condition==1){
        if($newUnit == 1){
            echo ($recentValues->getTemperatureF() . "&#176;F");									
        }
        else{
            echo ($recentValues->getTemperatureC() . "&#176;C");									
        }
    }
    elseif($condition==2){
        if($newUnit == 1){
            echo ($recentValues->getHeatIndexF() . "&#176;F");									
        }
        else{
            echo ($recentValues->getHeatIndexC() . "&#176;C");									
        }
    }
    elseif($condition==3){
        if($newUnit == 1){
            echo ($recentValues->getPressureMbar() . " mb");									
        }
        else{
            echo ($recentValues->getPressureMmhg() . " mmhg");									
        }
    }
    elseif($condition==4){
        if($newUnit == 1){
            echo ($recentValues->getSnowfallcm() . " cm");									
        }
        else{
            echo ($recentValues->getSnowfallIn() . " in");									
        }
    }
    elseif($condition==5){
        if($newUnit == 1){
            echo ($recentValues->getBoilingPointF() . " &#176;F");									
        }
        else{
            echo ($recentValues->getBoilingPointC() . " &#176;C");									
        }
    }
    elseif($condition==6){
        if($newUnit == 1){
            echo ($recentValues->getWindSpeedMph() . " MPH");									
        }
        else if($newUnit == 2){
            echo ($recentValues->getWindSpeedFps() . " ft/s");
        }
        else if($newUnit == 3){
            echo ($recentValues->getWindSpeedKmph() . " Km/h");
        }
        else{
            echo ($recentValues->getWindSpeedMps() . " m/s");									
        }
    }
?>