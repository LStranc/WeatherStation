<?php
	//echo file_put_contents("text.txt","Hello World. Testing!");
	
	$name = $_GET['name'];
	$color = $_GET['color'];
	$count = $_GET['count'];

	$fileContent = "Hi, ".$name.". Your favorite color is ".$color.". This is loop number ".$count.".\n";

	$fileStatus = file_put_contents('myFile.txt', $fileContent,FILE_APPEND);

	if ($fileStatus != false){
		echo "SUCCESS";
	}
	else{
		echo "FAIL";
	}
	

?>
