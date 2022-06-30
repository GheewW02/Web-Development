<?php
//Select weather data for given parameters
$sql = "SELECT *
FROM weather
WHERE city = '{$_GET['city']}'
AND weather_when >= DATE_SUB(NOW(), INTERVAL 5 SECOND)
ORDER BY weather_when DESC limit 1";

$result = $mysqli -> query($sql);


if ($result->num_rows == 0) {
$url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $_GET['city'] . '&appid=##############&units=metric';


//gets data from openweathermap and store in JSON object

$data = file_get_contents($url);
$json = json_decode($data, true);

//fetching required feilds

$weather_description = $json['weather'][0]['description'];
$weather_temperature = $json['main']['temp'];
$weather_wind = $json['wind']['speed'];
$weather_when = date("Y-m-d H:i:s"); // now
$city = $json['name'];
$pressure = $json['main']['pressure'];
$humidity = $json['main']['humidity'];
$icon = $json['weather'][0]['icon'];
$temperature_max = $json['main']['temp_max'];
$temperature_min = $json['main']['temp_min'];
$feels_like = $json['main']['feels_like'];


$sql = "INSERT INTO weather (weather_description, weather_temperature, weather_wind, weather_when, city, pressure, humidity, icon, temperature_max, temperature_min, feels_like)
VALUES('{$weather_description}', {$weather_temperature}, {$weather_wind}, '{$weather_when}', '{$city}', '{$pressure}', '{$humidity}', '{$icon}', '{$temperature_max}', '{$temperature_min}', '{$feels_like}')";


if (!$mysqli -> query($sql)) {
echo("<h4>SQL error description: " . $mysqli -> error . "</h4>");

}
}
?>