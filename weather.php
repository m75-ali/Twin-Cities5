<?php
// Read config file
$config_file = 'config.php';
require '$config.php';

// Extract database connection details
$api_key = $config['apiKeys']['openWeather'];

// City name
$city = 'London'; // Replace with the desired city name

// API URL
$url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $api_key . "&units=metric";

// Fetch weather data
$weather_data = file_get_contents($url);

if ($weather_data) {
    // Decode JSON response
    $weather_info = json_decode($weather_data, true);

    // Check if API request was successful
    if ($weather_info && isset($weather_info['main'], $weather_info['weather'], $weather_info['wind'])) {
        // Extract relevant weather information
        $temperature = $weather_info['main']['temp'];
        $weather_description = $weather_info['weather'][0]['description'];
        $humidity = $weather_info['main']['humidity'];
        $wind_speed = $weather_info['wind']['speed'];

        // Display weather information
        echo "City: " . $city . "<br>";
        echo "Temperature: " . $temperature . "°C<br>";
        echo "Weather: " . ucfirst($weather_description) . "<br>";
        echo "Humidity: " . $humidity . "%<br>";
        echo "Wind Speed: " . $wind_speed . " m/s<br>";
    } else {
        echo "Error: Unable to retrieve weather data.";
    }
} else {
    echo "Error: Unable to connect to OpenWeatherMap API.";
}
?>
