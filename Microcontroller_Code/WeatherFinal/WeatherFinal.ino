#include "LowPower.h" //for sleep periods of microcontroller
#include <SoftwareSerial.h> // for serial communication needed for esp and air sensor
#include "Adafruit_PM25AQI.h" //air sensor library for easy interface
//BMP280 Packages
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>

#include "encrypt.h" //import ip and wifi connection information

// pins tx(pin 0) and rx(pin 1) are left floating
#define TRIGPIN 4 //ultrasonic trigger
#define ECHOPIN 5 //ultrasonic echo
#define POWERESP 8 //power for esp
#define POWERMAIN 9 //power for bme, rain, and uv sensors
#define POWERWIND 10 //power for wind sensor
#define BATTERYPIN A1 //battery voltage pin
#define SUNPIN A2 // solar panel voltage pin
#define WINDPIN A3 //wind sensor pin
#define UVPIN A6  // uv light sensor pin
#define RAINPIN A7 //Rain sensor pin

#define SERIALSPEED 115200               
#define DEBUG false 
SoftwareSerial esp8266(11,12);                   

SoftwareSerial pmSerial(2, 3); //only tx pin 2 is used, rx pin 3 is floating
Adafruit_PM25AQI aqi = Adafruit_PM25AQI();
PM25_AQI_Data data;

Adafruit_BME280 bme; // creates I2C BMP280 object, uses pins

float temperature = 0.0;
long pressure = 0;
float humidity = 0;
int precipitation = 0;
int sun = 800;
float windSpeed = 0;
int uvIndex = 1;
long cm = 0;
int battery = 0;

 
void setup(){
  Serial.begin(SERIALSPEED); 
  intPins();
}

void loop(){
  //sun = analogRead(SUNPIN); //store sun voltage reading
  deepSleep(30);
  battery = analogRead(BATTERYPIN); //store battery voltage reading
  delay(5000);
  readMainBus(); //reads data from bme, rain, and uv sensor
  delay(5000); // heavy load to heavy load, let circuit reach steady state 
  readWindBus(); // reads data from wind sensor
  delay(5000);
  sendWiFiOnBus(); //powerup and initialize esp and send weather data
  deepSleep(5); // sleep for 5*8= 40seconds
}

void deepSleep(int EightSecondIntervals){
  int i = 0;
  while(i<EightSecondIntervals){
  LowPower.powerDown(SLEEP_8S, ADC_OFF, BOD_OFF); //deep sleep for 8 seconds
  i++;
  } 
}

void intPins(){
  pinMode(POWERMAIN,OUTPUT);
  pinMode(POWERWIND,OUTPUT);
  pinMode(POWERESP,OUTPUT);
  digitalWrite(POWERMAIN, LOW);
  digitalWrite(POWERWIND, LOW);
  digitalWrite(POWERESP, LOW);

  
  //Ultrasonic sensor setup pins
  pinMode(TRIGPIN, INPUT); //InputPullup = 28uA, Input = 0 uA
  pinMode(ECHOPIN, INPUT); //InputPullup = 33 uA, Input
}

void readMainBus(){
  digitalWrite(POWERMAIN,HIGH); //give main bus power
  pinMode(TRIGPIN,OUTPUT);
  pinMode(ECHOPIN, INPUT); // set echo pin back to input
  delay(500);
  bme.begin(0x76); // bme initialize
  delay(2000); 
  temperature = bme.readTemperature(); //store temperature
  pressure = bme.readPressure(); //store pressure
  humidity = bme.readHumidity(); //store humidity
  delay(500);
  uvIndex = analogRead(UVPIN); //store uv voltage reading
  precipitation = analogRead(RAINPIN); //store precipitation voltage reading
  delay(1000);
  snowSensorRead(); // read snow height data
  delay(15000); //let sensor warmup for 15 seconds  
  airSensorRead(); // read air quality data 
  pinMode(TRIGPIN, INPUT); //set trigpin back to input pullup to convserve power
  digitalWrite(POWERMAIN,LOW);
}

void airSensorRead(){
  pmSerial.begin(9600); //begin serial communication with air sensor
  while (! aqi.begin_UART(&pmSerial)){ // wait while air sensor has not begun serial communication
    digitalWrite(13, HIGH);
    delay(1000);
    digitalWrite(13,LOW);
    delay(1000);
  }
  while (! aqi.read(&data) && data.particles_03um <= 1) { //wait until good data is read, values are stored in data struct
    digitalWrite(13, HIGH);
    delay(250);
    digitalWrite(13,LOW);
    delay(250);
  }  
}

void snowSensorRead(){
  long duration;
  //Ultrasonic Snow Sensor Reading
  // The sensor is triggered by a HIGH pulse of 10 or more microseconds.
  // Give a short LOW pulse beforehand to ensure a clean HIGH pulse:.
  digitalWrite(TRIGPIN, LOW);
  delayMicroseconds(5);
  digitalWrite(TRIGPIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIGPIN, LOW);
  // Read the signal from the sensor: a HIGH pulse whose
  // duration is the time (in microseconds) from the sending
  // of the ping to the reception of its echo off of an object.
  duration = pulseIn(ECHOPIN, HIGH);
  // Convert the time into a distance
  cm = (duration/2) / 29.1;     // Divide by 29.1 or multiply by 0.0343
  //Assuming the sensor is 86 cm from the ground the difference between the distance
  // the ultrasonic sensor found and the actual ground will be the amount of snowfall
  // this calculation is done server side
}

void readWindBus(){
  digitalWrite(POWERWIND,HIGH); // give power to 3.3 to 12V step for wind sensor
  delay(30000); // wait a while for the sensor to heat up
  windSpeed = analogRead(WINDPIN);
  windSpeed =  pow(((((float)windSpeed) - 264.0) / 85.6814), 3.36814); //equation converts voltage read at output into wind speed in mph
  digitalWrite(POWERWIND,LOW); // turn off wind bus
}

String sendData(String command, const int timeout, boolean debug)
{
    String response = "";                                             
    esp8266.print(command);                                          
    long int time = millis();                                      
    while( (time+timeout) > millis())                                 
    {      
      while(esp8266.available())                                      
      {
        char c = esp8266.read();                                     
        response+=c;                                                  
      }  
    }    
    if(debug)                                                        
    {
      //Serial.print(response);
    }    
    return response;                                                  
}

void initWifiModule()
{
  String wifi_username = get_WiFi_Username();
  String wifi_password = get_WiFi_Password();
  
  esp8266.begin(SERIALSPEED);
  delay(1000);
  sendData("AT+RST\r\n", 2000, DEBUG); 
  sendData("AT+CWJAP=\"" + wifi_username + "\",\"" + wifi_password + "\"\r\n", 2000, DEBUG);        
  delay (3000);
  sendData("AT+CWMODE=1\r\n", 2000, DEBUG);                                          
  delay (1500);
  sendData("AT+CIFSR\r\n", 2000, DEBUG);                                                                    
  delay (1500);
  sendData("AT+CIPMUX=1\r\n", 2000, DEBUG);                                                                            
}

void sendWeatherData(){
  String ip = get_IP();
  
  sendData("AT+CIPSTART=0,\"TCP\",\"" + ip + "\",80\r\n", 6000, DEBUG); //attempt to start tcp communication with server port 80                              
  delay(500);
  String message = String("GET ") + "/receiverDB.php?" + 
              "temp="+ temperature +
              "&humidity=" + humidity +
              "&pressure=" + pressure +
              "&precipitation=" + precipitation +
              "&windspeed=" + windSpeed +
              "&sun=" + sun +
              "&parta=" + data.particles_03um +
              "&partb=" + data.particles_05um +
              "&partc=" + data.particles_10um +
              "&partd=" + data.particles_25um +
              "&parte=" + data.particles_50um +
              "&partf=" + data.particles_100um +
              "&uvindex=" + uvIndex +
              "&snowfall=" + cm +
              "&battery=" + battery + 
              " HTTP/1.1\r\n" + 
              "Host: " + ip + "\r\n\r\n"; //GET request of all data to be sent to server_ip/receiverDB.php     
   String cipSend = "AT+CIPSEND=0,";
   cipSend +=message.length(); 
   cipSend +="\r\n";
   delay(2000);
   sendData(cipSend,4000,DEBUG); //send full GET request message
   delay(2000);
   sendData(message,4000,DEBUG); //resend message
   String closeCommand = "AT+CIPCLOSE=0"; 
   closeCommand+="\r\n";  
   delay(2000);  
   sendData(closeCommand,4000,DEBUG); //close connection with server
}

void sendWiFiOnBus(){
  digitalWrite(POWERESP, HIGH);
  delay(500);
  initWifiModule(); //initialize esp on network settings
  delay(2000);
  sendWeatherData();
  delay(1000);
  digitalWrite(POWERESP,LOW);
}
