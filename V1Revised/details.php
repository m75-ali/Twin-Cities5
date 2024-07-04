<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the configuration file
$config = require 'config.php';
$dbConfig = $config['database'];

// Create a new database connection
$conn = new mysqli(
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['password'],
    $dbConfig['database'],
    $dbConfig['port']
);

// Check for a database connection error
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Initialize variables to hold place and location details
$placeDetails = null;
$locationDetails = null;

// Check if the 'placeId' GET parameter is set
if (isset($_GET['placeId'])) {
    $placeId = filter_var($_GET['placeId'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch place details
    $stmt = $conn->prepare("SELECT * FROM PlaceOfInterest WHERE PlaceID = ?");
    $stmt->bind_param("i", $placeId);

    // Execute the statement and fetch the results for PlaceOfInterest
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $placeDetails = $result->fetch_assoc();
        } else {
            echo "No details found for the selected place.";
            exit;
        }
    } else {
        echo "Error executing query: " . htmlspecialchars($stmt->error);
        exit;
    }
    $stmt->close();

    // Fetch location details
    $stmt = $conn->prepare("SELECT * FROM LocationDetails WHERE PlaceID = ?");
    $stmt->bind_param("i", $placeId);

    // Execute the statement and fetch the results for LocationDetails
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $locationDetails = $result->fetch_assoc();
        }
        // Note: It's possible there are no additional location details, so no else clause needed here.
    } else {
        echo "Error executing query for location details: " . htmlspecialchars($stmt->error);
        exit;
    }
    $stmt->close();

} else {
    echo "No Place ID provided.";
    exit;
}

// Close the database connection
$conn->close();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .details-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Creates two columns of equal width */
            gap: 20px; /* Adds space between the columns */
        }
        .details-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #007BFF;
        }
        p {
            margin: 10px 0;
        }
        img {
            width: 100%;
            max-width: 400px; /* Adjusts image size, maintaining aspect ratio */
            height: auto;
            border-radius: 8px;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php if ($placeDetails): ?>
        <div class="details-container">
            <!-- Place Details -->
            <div class="details-section">
                <h1><?php echo htmlspecialchars($placeDetails['Name']); ?></h1>
                <img src="<?php echo htmlspecialchars($placeDetails['Photo']); ?>" alt="Place Image">
                <p>Type: <?php echo htmlspecialchars($placeDetails['Type']); ?></p>
                <p>Capacity: <?php echo htmlspecialchars($placeDetails['Capacity']); ?></p>
                <p>Description: <?php echo htmlspecialchars($placeDetails['Description']); ?></p>
                <p>Opening Hours: <?php echo htmlspecialchars($placeDetails['OpeningHours']); ?></p>
                <p>Rating: <?php echo htmlspecialchars($placeDetails['Rating']); ?></p>
            </div>

            <!-- Location Details -->
            <?php if ($locationDetails): ?>
                <div class="details-section">
                    <h2>More About This Location</h2>
                    <p>Historical Significance: <?php echo htmlspecialchars($locationDetails['HistoricalSignificance']); ?></p>
                    <p>Cultural Relevance: <?php echo htmlspecialchars($locationDetails['CulturalRelevance']); ?></p>
                    <p>Architectural Style: <?php echo htmlspecialchars($locationDetails['ArchitecturalStyle']); ?></p>
                    <p>Year Established: <?php echo htmlspecialchars($locationDetails['YearEstablished']); ?></p>
                    <p>Visitor Info: <?php echo htmlspecialchars($locationDetails['VisitorInfo']); ?></p>
                    <p>Accessibility Options: <?php echo htmlspecialchars($locationDetails['AccessibilityOptions']); ?></p>
                    <p>Website: <a href="<?php echo htmlspecialchars($locationDetails['WebsiteURL']); ?>" target="_blank"><?php echo htmlspecialchars($locationDetails['WebsiteURL']); ?></a></p>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Details for the selected place are not available.</p>
    <?php endif; ?>
    <?php if (!empty($newsArticles)): ?>
    <div class="details-section">
        <h2>Latest News</h2>
        <?php foreach ($newsArticles as $article): ?>
            <p><strong><?php echo htmlspecialchars($article['title']); ?></strong></p>
            <p><?php echo htmlspecialchars($article['description']); ?></p>
            <a href="<?php echo htmlspecialchars($article['url']); ?>" target="_blank">Read more</a>
            <hr>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</body>
</html>
