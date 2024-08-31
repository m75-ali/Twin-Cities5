<?php
// config.php

// Define the configuration array.
$config = [
    'apiKeys' => [
        'googleMaps' => 'AIzaSyDsqqHHzPrAFfSLy4kO8OnCaQEw-yrTjLA',
        'openWeather' => 'd296a2cf1989fd59447f7cc288b23f61',
        'news' => '4565ffea984e4c6ca81e90bb5d7e2cbd',
    ],
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'username' => 'root',
        'password' => 'root',
        'database' => 'twin_cities5',
    ],
    'weatherApiBaseUrl' => 'http://api.openweathermap.org/data/2.5/',
    'defaultMapCoordinates' => ['lat' => 51.5072, 'lng' => -0.1276], // Example: London's coordinates
    'defaultCityID' => 1, // Default redirect if no city ID is provided
];

// Function to validate the configuration.
function validateConfig(array $config): void {
    // Add validation checks as needed
}

// Validate the configuration.
try {
    validateConfig($config);
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Configuration error: " . $e->getMessage());
}

// Return the validated configuration.
return $config;
