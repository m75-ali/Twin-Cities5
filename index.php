<?php
// Read config file
$config_file = 'config.php';
$config = require 'config.php';
$googleMapsApiKey = $config['apiKeys']['googleMaps'];
$openWeatherApiKey = $config['apiKeys']['openWeather'];


// Extract database connection details
$db_host = $config['database']['host'];
$db_username = $config['database']['username'];
$db_password = $config['database']['password'];
$db_name = $config['database']['database'];
$weatherApi = $config['apiKeys']['openWeather'];
$googleMapApi = $config['apiKeys']['googleMaps'];

// Connect to MySQL database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}
$city_id = '';
// Check if city ID is provided in $_GET parameter
if (isset($_GET['city'])) {
    // Get city ID and ensure it's an integer to prevent SQL injection
    $city_id = (int)$_GET['city'];

    // Prepare a statement for safer and more secure execution
    $stmt = $conn->prepare("SELECT * FROM TownCity WHERE CityID = ?");
    $stmt->bind_param("i", $city_id); // 'i' specifies the parameter type is integer

    // Execute the prepared statement
    if ($stmt->execute()) { 
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $country_name = $row["Country"];
        } else {
            // Consider handling the case where no results are found more explicitly
            $country_name = null; // Or a descriptive string or action
        }
    } else {
        // Handle query execution error
        // Log this error or notify someone if needed
        echo "Error executing query.";
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect if no city ID is provided in the URL
    header('Location: index.php?city=1');
    exit; // Ensure no further code is executed after a redirect
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lo-Ly Twins</title>
        <link rel="stylesheet" href="./assets/css/style.css">
        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleMapApi; ?>"></script>
    </head>

    <body>
        <?php include ('header.php'); ?>
        <main>
            <section>
                <div class="container">
                    <h2 class="title text-center">
                        <?php echo $row["Name"]; ?>
                    </h2> <!-- Display city name here -->
                    <div class="flex">
                        <div class="left">
                            <table class="city-table">
                                <tbody>
                                    <tr class="h-row">
                                        <th colspan="2">
                                            <span>Country</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Country Name: </th>
                                        <td>
                                            <?php echo $country_name; ?>
                                        </td> <!-- Display country name here -->
                                    </tr>
                                    <tr class="h-row">
                                        <th colspan="2">
                                            <span>City Details</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Population: </th>
                                        <td>
                                            <?php echo $row['Population']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Geo Location: </th>
                                        <td>
                                            <?php echo $row['Latitude']; ?>&deg;,
                                            <?php echo $row['Longitude']; ?>&deg;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Currency: </th>
                                        <td>
                                            <?php echo $row['Currency']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Timezone: </th>
                                        <td>
                                            <?php echo $row['Timezone']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Area: </th>
                                        <td>
                                            <?php echo $row['Area']; ?> km<sup>2</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Official Language: </th>
                                        <td>
                                            <?php echo $row['OfficialLanguage']; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($row['Name']) . "&appid=" . $weatherApi . "&units=metric";

                                    // Fetch weather data
                                    $weather_data = file_get_contents($url);

                                    if ($weather_data) {
                                        // Decode JSON response
                                        $weather_info = json_decode($weather_data, true);

                                        // Check if API request was successful
                                        if ($weather_info && isset ($weather_info['main'], $weather_info['weather'], $weather_info['wind'])) {
                                            // Extract relevant weather information
                                            $temperature = $weather_info['main']['temp'];
                                            $weather_description = $weather_info['weather'][0]['description'];
                                            $humidity = $weather_info['main']['humidity'];
                                            $wind_speed = $weather_info['wind']['speed'];
                                            ?>
                                            <tr class="h-row">
                                                <th colspan="2">
                                                    <span>Current Weather</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Temperature: </th>
                                                <td>
                                                    <?php echo $temperature; ?>°C
                                                </td> <!-- Display temperature here -->
                                            </tr>
                                            <tr>
                                                <th>Weather: </th>
                                                <td>
                                                    <?php echo ucfirst($weather_description); ?>
                                                </td> <!-- Display weather description here -->
                                            </tr>
                                            <tr>
                                                <th>Humidity: </th>
                                                <td>
                                                    <?php echo $humidity; ?>%
                                                </td> <!-- Display humidity here -->
                                            </tr>
                                            <tr>
                                                <th>Wind Speed: </th>
                                                <td>
                                                    <?php echo $wind_speed; ?> m/s
                                                </td> <!-- Display wind speed here -->
                                            </tr>
                                            <?php
                                            // Make API request to OpenWeather for five-day forecast
                                            $forecast_url = 'http://api.openweathermap.org/data/2.5/forecast?q=' . urlencode($row['Name']) . "&appid=" . $weatherApi;
                                            $forecast_response = file_get_contents($forecast_url);
                                            $forecast_data = json_decode($forecast_response, true);

                                            // Extract forecast weather information
                                            $forecast = '';
                                            if ($forecast_data && isset ($forecast_data['list'])) {
                                                echo '
                                        <tr class="h-row">
                                            <th colspan="2">
                                                <span>Forecast</span>
                                            </th>
                                        </tr>';
                                                $k = 0;
                                                $currDate = '';
                                                foreach ($forecast_data['list'] as $forecast_item) {
                                                    $prev_date = $currDate;
                                                    $currDate = date('d-M-Y', strtotime($forecast_item['dt_txt']));

                                                    if ($prev_date !== $currDate) {
                                                     echo '<tr class="forecast"><th>' . $currDate . '</th><td><b>Temp:</b> ' . ($forecast_item['main']['temp'] - 273.15) . ', <b>Conditions:</b> ' . $forecast_item['weather'][0]['main'] . ', <b>Humidity:</b> ' . $forecast_item['main']['humidity'] . ', <b>Wind Speed:</b> ' . $forecast_item['wind']['speed'] . '</td></tr>';                                                    }
                                                    $k++;
                                                }
                                            }
                                        } else {
                                            echo "<td colspan='2'>Error: Unable to retrieve weather data.</td>";
                                        }
                                    } else {
                                        echo "<td colspan='2'>Error: Unable to connect to OpenWeatherMap API.</td>";
                                    }
                                    $sql2 = "SELECT * FROM Events WHERE CityID = $city_id";
                                    $result2 = $conn->query($sql2);

                                    if ($result2->num_rows > 0) {

                                        ?>
                                        <tr class="h-row">
                                            <th colspan="2">
                                                <span>Events</span>
                                            </th>
                                        </tr>
                                        <?php
                                        while ($row2 = $result2->fetch_assoc()) {
                                            echo '<tr><th>' . $row2['Name'] . ', ' . date('d M Y', strtotime($row2['Date'])) . '</th><td>' . $row2['Description'] . '</td></tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="right">
                            <table class="city-table">
                                <tbody>
                                    <tr class="h-row">
                                        <th colspan="2">
                                            <span>Places of Interest</span>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="map" id="map"></div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
$(document).ready(function () {
    // Conditional center based on city ID
    var cityId = "<?php echo $city_id; ?>"; // Ensure this PHP variable is correctly set
    var centerCoordinates = {lat: 51.5072, lng: -0.1144}; // Default to London's coordinates

    if (cityId === "2") {
        centerCoordinates = {lat: 40.7484, lng: -73.9857}; // New York, Empire State Building
    }

    var mapOptions = {
        center: centerCoordinates,
        zoom: 11.6,
        disableDefaultUI: true,
        gestureHandling: 'none',
        draggable: false,
        scrollwheel: false
    };

    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
    var placesOfInterest = [
        // Your PHP code block for placesOfInterest remains the same, no changes needed here
        <?php
        $places_query = "SELECT * FROM PlaceOfInterest WHERE CityID = $city_id";
        $places_result = $conn->query($places_query);
        if ($places_result->num_rows > 0) {
            while ($place_row = $places_result->fetch_assoc()) {
                echo "{";
                echo "name: '" . addslashes($place_row["Name"]) . "',";
                echo "lat: " . $place_row["Latitude"] . ",";
                echo "lng: " . $place_row["Longitude"] . ",";
                echo "type: '" . addslashes($place_row["Type"]) . "',";
                echo "capacity: '" . $place_row["Capacity"] . "',";
                echo "description: '" . addslashes($place_row["Description"]) . "',";
                echo "rating: '" . $place_row["Rating"] . "',";
                echo "cityId: '" . $place_row["CityID"] . "',";
                echo "placeId: '" . $place_row["PlaceID"] . "'";
                echo "},";
            }
        }
        ?>
    ];

    // Marker adding logic remains unchanged, no modifications required
    placesOfInterest.forEach(function (place) {
        console.log(place); // Debugging line remains
        var marker = new google.maps.Marker({
            position: { lat: place.lat, lng: place.lng },
            map: map,
            title: place.name,
            icon: {
                url: './assets/img/map-pin.png',
                scaledSize: new google.maps.Size(30, 30),
                className: "map-pin"
            }
        });

        var openInfoWindowMouseover = null;

        marker.addListener('mouseover', function () {
            if (openInfoWindowMouseover !== null) {
                openInfoWindowMouseover.close();
            }
            var infoWindow = new google.maps.InfoWindow({
                content: '<div class="map-info-window"><h3>' + place.name + '</h3><p>Type: ' + place.type + '</p></div>'
            });
            infoWindow.open(map, marker);
            openInfoWindowMouseover = infoWindow;
        });

        marker.addListener('mouseout', function () {
            if (openInfoWindowMouseover !== null) {
                openInfoWindowMouseover.close();
                openInfoWindowMouseover = null;
            }
        });

        marker.addListener('click', function () {
            var detailPageUrl = `details.php?placeId=${place.placeId}`;
            window.open(detailPageUrl, '_blank');
        });
    });
});
</script>
</html>
