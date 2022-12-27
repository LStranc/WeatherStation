# WeatherStation
The goal of this project was to build a cordless personal weather station that can be put in your own backyard. The weather station sends data to a server and you can analyze, store and use the data in anyway you want. 

This project includes c file to upload to the microcontroller, the server files used to store data in the sql database and display it to the website, and the schematic and pcb files for the actual hardware.

## Hardware
The Mircocontoller I used in this project is the esp32. A more generalized arudino code file is uploaded to this repo also. The weather station reads temperature, humidity, and pressure through a BME280 chip. It has a water sensor to sense if it is rainig. It uses the solar panel to tell how bright/sunny it is outside. This solar panel is also charging the lipo battery that it is powering the weather station. There is a uv sensor that tells us the uv index. There is Wind Sensor Rev P made by Modern Devices that is able to measure the windspeed. Also, there is a PWM5005 sensor which measures the air quality. The esp samples each sensor input then sends the data wirelessly to the server.

## Server
The server stores the data from the weather station and puts it in a mySQL database. The server also hosts a website where a client can interact with current and previously stored data. 

## Future 
This project is still in progress but the hope for the future is to implement an machine algorithm to try to forcast the upcoming weather.