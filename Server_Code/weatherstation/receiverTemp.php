<?php
	$temp = $_GET['temp'];
	$rain = $_GET['rain'];
	$pressure = $_GET['pressure'];
	$humidity = $_GET['humidity'];
	$snowfall = $_GET['snowfall'];

	$isRaining = "";

	if (strcmp($rain,"1") == 0){
		$isRaining = "Raining";
	}
	else{
		$isRaining = "Not Raining";
	}

	$fileContent = "\n".$temp."          ".$isRaining."   ".$pressure."   ".$humidity."   ".$snowfall;

	$fileStatus = file_put_contents('myTemperatureFile.txt', $fileContent,FILE_APPEND);

	if ($fileStatus != false){
		echo "SUCCESS";
	}
	else{
		echo "FAIL";
	}


?>
