<?php
// Include the configuration file
$config = include 'config.php';

// Extract database connection details
$db_host = $config['database']['host'];
$db_username = $config['database']['username'];
$db_password = $config['database']['password'];
$db_name = $config['database']['database'];
$weatherApi = $config['apiKeys']['openWeather'];
$newsApiKey = $config['apiKeys']['news']; // Assuming this is correctly configured in your config.php

// Create a new RSS feed
$feed = '<?xml version="1.0" encoding="UTF-8"?>';
$feed .= '<rss version="2.0">';
$feed .= '<channel>';
$feed .= '<title>My City RSS Feed</title>';
$feed .= '<link>http://' . $_SERVER["HTTP_HOST"] . '/rss_feed.xml</link>';
$feed .= '<description>RSS feed for cities and places of interest</description>';

// Connect to MySQL database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch news for a city
function fetchNewsForCity($cityName, $apiKey) {
    $newsUrl = "https://newsapi.org/v2/everything?q=" . urlencode($cityName) . "&apiKey=" . $apiKey . "&sortBy=publishedAt&pageSize=5";
    $newsJson = @file_get_contents($newsUrl);
    if ($newsJson) {
        return json_decode($newsJson, true);
    }
    return null;
}

// Query for cities
$sql_cities = "SELECT TownCity.*, Country.Name AS CountryName FROM TownCity JOIN Country ON TownCity.CountryID = Country.CountryID";
$result_cities = $conn->query($sql_cities);

if ($result_cities->num_rows > 0) {
    while ($city_row = $result_cities->fetch_assoc()) {
        $city_id = $city_row["CityID"];
        $city_name = $city_row["Name"];
        $country_name = $city_row["CountryName"];
        $population = $city_row["Population"];
        // Add city node
        $feed .= '<item>';
        $feed .= '<title>' . htmlspecialchars($city_name) . '</title>';
        $feed .= '<description>Population: ' . htmlspecialchars($population) . ', Country: ' . htmlspecialchars($country_name) . '</description>';

        // Fetch weather data
        $url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city_name) . "&appid=" . $weatherApi . "&units=metric";
        $weather_data = @file_get_contents($url);
        if ($weather_data) {
            $weather_info = json_decode($weather_data, true);
            if ($weather_info && isset($weather_info['main'], $weather_info['weather'], $weather_info['wind'])) {
                $temperature = $weather_info['main']['temp'];
                $weather_description = $weather_info['weather'][0]['description'];
                $humidity = $weather_info['main']['humidity'];
                $wind_speed = $weather_info['wind']['speed'];
                $feed .= "<weather>Temperature: $temperature °C, Description: $weather_description, Humidity: $humidity%, Wind Speed: $wind_speed m/s</weather>";
            }
        }

        // Fetch news for the city
        $newsData = fetchNewsForCity($city_name, $newsApiKey);
        if ($newsData && isset($newsData['articles'])) {
            foreach ($newsData['articles'] as $article) {
                $newsTitle = htmlspecialchars($article['title']);
                $newsDescription = htmlspecialchars($article['description']);
                $feed .= "<news><title>$newsTitle</title><description>$newsDescription</description></news>";
            }
        }

        // Query for places of interest for the city
        $sql_places = "SELECT PlaceOfInterest.*, LocationDetails.* FROM PlaceOfInterest LEFT JOIN LocationDetails ON PlaceOfInterest.PlaceID = LocationDetails.PlaceID WHERE CityID = $city_id";
        $result_places = $conn->query($sql_places);
        if ($result_places->num_rows > 0) {
            while ($place_row = $result_places->fetch_assoc()) {
                $place_name = $place_row["Name"];
                $place_type = $place_row["Type"];
                $description = $place_row["Description"];
                $feed .= "<place><name>$place_name</name><type>$place_type</type><description>$description</description></place>";
            }
        }

        $feed .= '</item>'; // Close the city item
    }
}

$feed .= '</channel>';
$feed .= '</rss>';

// Save the feed to a file
file_put_contents('rss_feed.xml', $feed);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>City RSS Feed</title>
</head>
<body>
    <main>
        <div class="container">
            <a href="rss_feed.xml" target="_blank">View RSS Feed</a>
        </div>
    </main>
</body>
</html>
