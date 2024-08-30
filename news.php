<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Read config file
require_once 'config.php'; // Ensure config.php is included only once

// News API Key
$api_key = '4565ffea984e4c6ca81e90bb5d7e2cbd';

// Define the fetch_news function
function fetch_news($city, $api_key) {
    $url = "https://newsapi.org/v2/everything?q=" . urlencode($city) . "&apiKey=" . $api_key;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Set User-Agent header
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: YourAppName/1.0'
    ]);

    $output = curl_exec($ch);

    if ($output === FALSE) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return "cURL Error: " . $error_msg;
    }

    curl_close($ch);
    return $output;
}

// Only run the following code if accessed directly
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    // Cities array
    $cities = ['London', 'New York'];

    // Start HTML output
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>News Headlines</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .city-news { margin-bottom: 40px; }
            .article { margin-bottom: 20px; }
            h2 { color: #333; }
            h3 { margin: 0; color: #007BFF; }
            p { margin: 5px 0; }
        </style>
    </head>
    <body>';

    // Loop through the cities array
    foreach ($cities as $city) {
        // Fetch news data
        $news_data = fetch_news($city, $api_key);

        if (strpos($news_data, "cURL Error:") === 0) {
            echo "<div class='city-news'><h2>Error: Unable to connect to News API for city " . $city . ". " . $news_data . "</h2></div>";
            continue;
        }

        // Decode JSON response
        $news_info = json_decode($news_data, true);

        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "<div class='city-news'><h2>Error: JSON decoding error for city " . $city . ": " . json_last_error_msg() . "</h2></div>";
            continue;
        }

        // Check if API request was successful and news data is available
        if ($news_info && isset($news_info['articles']) && !empty($news_info['articles'])) {
            echo "<div class='city-news'>";
            echo "<h2>News for " . $city . ":</h2>";
            $articles = array_slice($news_info['articles'], 0, 2); // Get only the first 2 articles
            foreach ($articles as $article) {
                $title = $article['title'];
                $description = $article['description'];
                echo "<div class='article'>";
                echo "<h3>" . htmlspecialchars($title) . "</h3>";
                echo "<p>" . htmlspecialchars($description) . "</p>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='city-news'><h2>Error: No news available for " . $city . ".</h2></div>";
        }
    }

    // End HTML output
    echo '</body></html>';
}
?>
