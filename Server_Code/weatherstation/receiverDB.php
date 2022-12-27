<?php
require('hide.php');

$servername = get_servername();
$username = get_username();
$password = get_password();
$dbname = get_dbname();

$temp = htmlspecialchars($_GET['temp']);
$humidity = htmlspecialchars($_GET['humidity']);
$pressure = htmlspecialchars($_GET['pressure']);
$precipitationRaw = htmlspecialchars($_GET['precipitation']);
$windSpeed = htmlspecialchars($_GET['windspeed']);
$sun = htmlspecialchars($_GET['sun']);
$part3 = htmlspecialchars($_GET['parta']);
$part5 = htmlspecialchars($_GET['partb']);
$part10 = htmlspecialchars($_GET['partc']);
$part25 = htmlspecialchars($_GET['partd']);
$part50 = htmlspecialchars($_GET['parte']);
$part100 = htmlspecialchars($_GET['partf']);
$uvIndexRaw = htmlspecialchars($_GET['uvindex']);
$cm = htmlspecialchars($_GET['snowfall']);
$battery = htmlspecialchars($_GET['battery']);

if($precipitationRaw < 600){
	if($temp >= 3){
		$precipitation = 'Raining';
	}
	elseif($temp > 0){
		$precipitation = 'Wintery-Mix';
	}
	else{
		$precipitation = 'Snowing';
	}
}
else{
	if($sun>= 900){
		$precipitation = 'Clear';
	}
	else{
		$precipitation = 'Cloudy';
	}
}


if($uvIndexRaw <33){ // this is for 5 V, needs to be adjusted for 3.3V
	$uvIndex = 0;
}
elseif($uvIndexRaw <150){
	$uvIndex = 1;
}
elseif($uvIndexRaw < 210){
	$uvIndex = 2;
}
elseif($uvIndexRaw < 270){
	$uvIndex = 3;
}
elseif($uvIndexRaw < 332){
	$uvIndex = 4;
}
elseif($uvIndexRaw < 400){
	$uvIndex = 5;
}
elseif($uvIndexRaw < 460){
	$uvIndex = 6;
}
elseif($uvIndexRaw < 525){
	$uvIndex = 7;
}
elseif($uvIndexRaw < 582){
	$uvIndex = 8;
}
elseif($uvIndexRaw < 646){
	$uvIndex = 9;
}
elseif($uvIndexRaw < 712){
	$uvIndex = 10;
}
else{
	$uvIndex = 11;
}

$snowfall = 86-$cm; //The constant needs to be calibrated  according to the height of the sensor from the ground.

$fileAppend = fopen('debug.txt','w')or die("Didn't make file"); //appends debug.txt
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	fwrite($fileAppend, "Connection Failed: ".$conn->connect_error);
	fclose($fileAppend);
	die("Connection Failed: ".$conn->connect_error);

}


$sql = "INSERT INTO weatherData (Temp, Humidity, Pressure, Precipitation, WindSpeed, Part0_3, Part0_5, Part1, Part2_5, Part5, Part10, UVIndex, SnowFall, Battery) VALUES (". $temp . "," . $humidity . "," . $pressure . ", '" . $precipitation . "'," . $windSpeed . "," . $part3 . "," . $part5 . "," . $part10 . "," . $part25 . "," . $part50 . "," . $part100 . "," . $uvIndex . "," . $snowfall . "," . $battery . ")";

if ($conn->query($sql) === TRUE) {
	fwrite($fileAppend, "New record successfull,\n".$sql);
	echo "New record created successfully";
	echo $sql;
} else{
	fwrite($fileAppend, "New record Failed,\n".$sql ."\n". $conn->error);
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$con->close();
fclose($fileAppend);

?>
