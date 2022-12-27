<?php 
	require('RetrieveValues.php');
	$recentValues = new RetrieveValues; 
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Home Wifi Weather Station </title>
		<link href="assets/home.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/
		3.2.0/jquery.min.js"></script>
	</head>
	<body>
	<div class="wrapper">
		<div id="banner">
			<h1 id="title">The Home Wifi Weather Station </h1>
		</div>

		<div class="nav">
			<ul>
				<li class="active"><a href="home.php"> Home </a></li>
				<li><a href="learn.php"> Learn </a></li>
				<li><a href="trends.php"> Past Trends</a></li>
				<li><a href="forcast.php"> Forcast</a></li>
				<li><a href="about.php"> About </a> </li>
				
			</ul>
		</div>
		<div class="body">
			`<div class="content">
				<div class="welcome">
					<p class="widget"> Welcome to the Home Wifi Weather Station, located in
						<br><a href="https://www.visitsaltlake.com/"> Salt Lake City, Utah! </a></p>
				</div>
				
				<div class="welcome">
					<p class="widget time"> Last Measurement Taken At: <br>
					<?php 
									echo ($recentValues->getTime());
							?> 
					</p>
				</div>
				<div class="main">
					<div class="grid">
						<div class="temperature widget">
							<ul class= widgetlist>
								<li class="widgetheader">Temperature  </li>
								<li id="temper" class="datavalue">
									<?php 										
										echo ($recentValues->getTemperatureF() . "&#176;F");
									?>
								</li>
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned unitChangeTemp"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>
							
						

						</div>
						<div class ="humidity widget">
							<ul class= widgetlist>
								<li> Humidity </li>
								<?php 
										echo ("<li class=\"datavalue\">" . $recentValues->getHumidity() . "% </li>");
								?>  
								
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>	
						</div>	
						<div class ="feelsLike widget">
							<ul class= widgetlist>
								<li> Feels Like </li>
								<li id="feels" class="datavalue">
									<?php 										
										echo ($recentValues->getHeatIndexF() . "&#176;F");
									?>
								</li>
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned unitChangeFeel"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>
						</div>
					</div>	
					<div class="welcome">
						<p class="widget sky"> <span class=greycircle>Right Now, the skies are: </span><br> <span class="skyfont">
						<?php 
										echo ($recentValues->getPrecipitation());
								?> 
						</span> <br><br>
					</p>
					</div>
					<div class="grid">			
						<div class="pressure widget">
							<ul class= widgetlist>
								<li> Pressure  </li>
								<li id="pressure" class="datavalue">
									<?php 										
										echo ($recentValues->getPressureMbar() . " mb");
									?>
								</li>
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned unitChangePressure"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>
						

						</div>
						<div class ="snowfall widget">
							<ul class= widgetlist>
								<li> Snowfall </li>
								<li id="snowfall" class="datavalue">
									<?php 										
										echo ($recentValues->getSnowfallcm() . " cm");
									?>
								</li>
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned unitChangeSnowfall"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>
						</div>	
						<div class ="boiling widget">
							<ul class= widgetlist>
								<li> Boiling Temp  </li>
								<li id="boiling" class="datavalue">
									<?php 										
										echo ($recentValues->getBoilingPointF() . " &#176;F");
									?>
								</li>
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned unitChangeBoiling"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>
						</div>
					</div>	
					<div class="grid2">
						<div class="widget circlelink">
							<a href="forcast.php"><p class="subgrid"> Check out my machine learning based forcast! </p></a>
						</div>
						<div class="widget circlelink">
							<a href="about.php"><p class="subgrid"> Learn more about how the weather station works! </p></a>
						</div>
					</div>
					<div class="grid">			
						<div class ="wind widget">
							<ul class= widgetlist>
								<li> Wind Speed </li>
								<li id="wind" class="datavalue">
									<?php 										
										echo ($recentValues->getWindSpeedMph() . " MPH");
									?>
								</li>
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned unitChangeWind"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>
						</div>

						<div class ="<?php echo ($recentValues->getUVColor()) ?> widget">
							<ul class= widgetlist>
								<li> UV Index  </li>
								<?php 
										echo ("<li class=\"datavalue\">" . $recentValues->getUVIndex() . " </li>");
								?> 
								
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>
						</div>
						<div class ="air widget">
							<ul class= widgetlist>
								<li> Air Quality </li>
								<?php 
										echo ("<li class=\"datavalue\">" . $recentValues->getAirQuality() . " ug/L </li>");
								?> 
								
							</ul>
							<div class="buttons"> 
								<p class="greycircle circlelink missaligned"> Change Units </p>
								<a href="learn.php">  <p class="greycircle circlelink missaligned"> Learn More </p></a>
								<a href="trends.php"> <p class="greycircle circlelink missaligned"> Past Trends </p></a>
							</div>
						</div>
					</div>
				
					<!--
					<div class="tabletitle">
						
					</div>
					<table>
						<tr>
							<th> Temperature  </th>
							<th> Humidity </th>
							<th> Heat Index </th>
							<th> Precipitation </th>
							<th> Pressure </th>
						</tr>
						<tr>
							<td>1 </td>
							<td>2 </td>
							<td>3 </td>
							<td>4 </td>
							<td>5 </td>
						</tr>
					</table>
					-->
					
				</div>
			</div>
		</div>
		<div class="footer">
			<h2> Check out more of my projects! </h2>
			<a href="https://github.com/LStranc?tab=repositories"><img src="pictures/GitHubLogo.png" id="githubLogo">
			<img src="pictures/GitHubLogo2.png" id="githubLogo2"></a>
			
			<h3> Thank you for visiting! </h3>
			<p>&copy; Logan Stranc, 2021-<span id="year"></span></p>
		</div>
	</div>
	<script src ="js/home.js"></script>
	</body>
</html>
