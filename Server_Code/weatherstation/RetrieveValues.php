<?php
class RetrieveValues{

  private $temperatureC;
  private $temperatureF;
  private $humidity;
  private $heatIndexC;
  private $heatIndexF;
  private $pressurePa;
  private $pressureMmhg;
  private $pressureMbar;
  private $snowfallCm;
  private $snowfallIn;
  private $boilingPointC;
  private $boilingPointF;
  private $precipitation;
  private $windSpeedMph;
  private $windSpeedFps;
  private $windSpeedKmph;
  private $windSpeedMps;
  private $part3;
  private $part5;
  private $part10;
  private $part25;
  private $part50;
  private $part100;
  private $airQuality;
  private $uvIndex;
  private $uvColor;
  private $time;

  public function __construct(){
    $servername = "localhost";
    $username = "root";
    $password = "WeatherBro8!";
    $dbname = "weatherStation";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM weatherData ORDER BY Time DESC LIMIT 1;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $this->temperatureC = $row["Temp"];
        $this->humidity = $row["Humidity"];
        $this->pressurePa = $row["Pressure"];
        $this->snowfallCm = $row["SnowFall"];
        $this->precipitation = $row["Precipitation"];
        $this->windSpeedMph = $row["WindSpeed"];
        $this->part3 = $row["Part0_3"];
        $this->part5 = $row["Part0_5"];
        $this->part10 = $row["Part1"];
        $this->part25= $row["Part2_5"];
        $this->part50 = $row["Part5"];
        $this->part100 = $row["Part10"];
        $this->uvIndex = $row["UVIndex"];
        $this->time = $row["Time"];

        $this->temperatureF = round(RetrieveValues::celToFar($this->temperatureC)*100)/100;
        $this->pressureMmhg = round(RetrieveValues::paToMmhg($this->pressurePa)*10)/10;
        $this->pressureMbar = round(RetrieveValues::paToMbar($this->pressurePa)*10)/10;
        $this->snowfallIn = round(RetrieveValues::cmToIn($this->snowfallCm)*10)/10;
        $this->windSpeedFps = round(RetrieveValues::mphToFps($this->getWindSpeedMph)*10)/10;
        $this->windSpeedKmph = round(RetrieveValues::mphToKmph($this->getWindSpeedMph)*10)/10;
        $this->windSpeedMps = round(RetrieveValues::mphToMps($this->getWindSpeedMph)*10)/10;


        $heatIndexF = -42.379 + 2.04901523*$this->temperatureF + 10.14333127*$this->humidity - 0.22475541 * $this->temperatureF * $this->humidity 
        - 0.00683783*$this->temperatureF**2 - 0.05481717 * $this->humidity**2 + 0.00122874*$this->temperatureF**2*$this->humidity 
        + 0.00085282 * $this->temperatureF * $this->humidity**2 - 0.00000199* $this->temperatureF**2 * $this->humidity**2;
        if($this->humidity<13 && $this->temperatureF >= 80 && $this->temperatureF <= 112){
          $heatIndexF = $heatIndexF - ((13-$this->humidity)/4)* sqrt((17-abs($this->temperatureF-95))/17);
        }
        else if($this->humidity>85 && $this->temperatureF >= 80 && $this->temperatureF <= 87){
            $heatIndexF = $heatIndexF - (($this->humidity-85)/10)*((87-$this->temperatureF)/5);
        }
        else if($heatIndexF < 80){
          $heatIndexF = 0.5 * ($this->temperatureF + 61.0 + (($this->temperatureF-68.0)*1.2) + ($this->humidity*0.094));
        }
        $this->heatIndexF = round($heatIndexF * 100)/100;
        $this->heatIndexC = round(RetrieveValues::farToCel($this->heatIndexF)*100)/100;
        
        $this->boilingPointC = round((100 + ($this->pressureMmhg - 760) * 0.045)*100)/100;
        $this->boilingPointF = round(RetrieveValues::celToFar($this->boilingPointC)*100)/100;



        if($this->uvIndex <= 2){
          $this->uvColor = "uvGreen";
        }
        elseif($this->uvIndex <= 5){
          $this->uvColor = "uvYellow";
        }
        elseif($this->uvIndex <= 7){
          $this->uvColor = "uvOrange";
        }
        elseif($this->uvIndex <= 10){
          $this->uvColor = "uvRed";
        }
        else{
          $this->uvColor = "uvDanger";
        }

        if($this->part25 <= 12){
          $this->airQuality = "Good";
        }
        elseif($this->part25 <= 35.4){
          $this->airQuality = "Moderate";
        }
        elseif($this->part25 <= 55.4){
          $this->airQuality = "Unhealthy For Sensitive Groups";
        }
        elseif($this->part25 <= 150.4){
          $this->airQuality = "Unhealthy";
        }
        elseif($this->part25 <= 250.4){
          $this->airQuality = "Very Unhealthy";
        }
        else{
          $this->airQuality = "Hazardous";
        }
      }
    } else {
      echo "0 results";
    }

    $conn->close();
  }

  public function getTemperatureC(){
    return $this->temperatureC;
  }

  public function getTemperatureF(){
    return $this->temperatureF;
  }

  public function getHumidity(){
    return $this->humidity;
  }

  public function getWindSpeedMph(){
    return $this->windSpeedMph;
  }

  public function getWindSpeedFps(){
    return $this->windSpeedFps;
  }

  public function getWindSpeedKmph(){
    return $this->windSpeedKmph;
  }

  public function getWindSpeedMps(){
    return $this->windSpeedMps;
  }

  public function getHeatIndexF(){
    return $this->heatIndexF;
  }

  public function getHeatIndexC(){
    return $this->heatIndexC;
  }

  public function getPressurePa(){
    return $this->pressurePa;
  }

  public function getPressureMmhg(){
    return $this->pressureMmhg;
  }

  public function getPressureMbar(){
    return $this->pressureMbar;
  }

  public function getBoilingPointC(){
    return $this->boilingPointC;
  }

  public function getBoilingPointF(){
    return $this->boilingPointF;
  }

  public function getSnowfallcm(){
    return $this->snowfallCm;
  }

  public function getSnowfallIn(){
    return $this->snowfallIn;
  }

  public function getPrecipitation(){
    return $this->precipitation;
  }

  public function getUVIndex(){
    return $this->uvIndex;
  }

  public function getUVColor(){
    return $this->uvColor;
  }

  public function getPart3(){
    return $this->part3;
  }

  public function getPart5(){
    return $this->part5;
  }

  public function getPart10(){
    return $this->part10;
  }

  public function getPart25(){
    return $this->part25;
  }

  public function getPart50(){
    return $this->part50;
  }

  public function getPart100(){
    return $this->part100;
  }

  public function getAirQuality(){
    return $this->getAirQuality;
  }

  public function getTime(){
    return $this->time;
  }

  public static function celToFar($cel){
    return $cel * (9/5) + 32;
  }

  public static function farToCel($far){
    return ($far-32) * (5/9);
  }

  public static function paToMmhg($pa){
    return $pa * 0.00750062;
  }

  public static function paToMbar($pa){
    return $pa / 100;
  }

  public static function cmToIn($cm){
    return $cm / 2.54;
  }

  public static function mphToFps($mph){
    return $mph * 1.467;
  }

  public static function mphToKmph($mph){
    return $mph * 1.609;
  }

  public static function mphToMps($mph){
    return $mph / 2.237;
  }

}
?>