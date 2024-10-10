<?php
// CORS headers
header("Access-Control-Allow-Origin: https://character-sheet.mariano-pfister.ch");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Define the directory where your JSON files are stored
define('DATA_DIR', __DIR__ . '/data/');

require_once('./config.php');
require_once('./auth.php');

// Check if the user is logged in
if (!isLoggedIn()) {
    // If the user is not logged in, redirect to the login page or display an error message
    header("Location: /login/login.php");
    exit;
}
// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Endpoint to list all files in the /data folder
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'listFiles') {
    $files = array_diff(scandir(DATA_DIR), array('..', '.'));
    sendResponse($files);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['character'])) {
    $characterName = $_GET['character'];
    header("Location:  /app?character=$characterName");
    exit;
}

// Function to send a JSON response
function sendResponse($data, $httpCode = 200) {
    http_response_code($httpCode);
    echo json_encode($data);
    exit;
}
// Handle GET requests to retrieve JSON data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getData' && isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $filePath = DATA_DIR . $filename;

    if (file_exists($filePath)) {
        $data = file_get_contents($filePath);
        sendResponse(json_decode($data, true));
    } else {
        sendResponse(['error' => 'File not found'], 404);
    }
}

// Handle POST requests to save data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for action and filename to save data
    $postData = json_decode(file_get_contents('php://input'), true); // Read raw POST data
    if (isset($postData['action']) && $postData['action'] === 'saveData' && isset($postData['fileName']) && file_exists($postData['fileName']) ) {
        $fileName = $postData['fileName'];
        $filePath = DATA_DIR . $fileName;

        // Attempt to save the data
        if (file_put_contents($filePath, json_encode($postData))) {
            sendResponse(['message' => 'Data saved successfully', 'fileName' => $fileName]);
        } else {
            sendResponse(['error' => 'Error writing to file', 'fileName' => $fileName], 500);
        }
    } else {
        sendResponse(['error' => 'Invalid file name or input'], 400); // Return a bad request error
    }
}
?>

<?php header("Content-Type: text/html"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/base.css">
    <title>Login</title>
</head>
<body>
    <article>
        <h1>Characters</h1>
        <?php
            $files = array_diff(scandir(DATA_DIR), array('..', '.'));
            foreach ($files as $key => $value) {
        ?>
        <section>
            <a href="/app/?character=<?php echo substr($value, 0, -5) ?>"><span><?php echo substr($value, 0, -5) ?></span></a>
        </section>
        <?php
            }
        ?>
    </article>
</html>