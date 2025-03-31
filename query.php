<?php

header("Content-Type: application/json");

// Database Connection
$servername = ".............";
$username = "root";
$password = "";
$dbname = "project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Function to execute SQL queries
function executeQuery($sql) {
    global $conn;
    $result = $conn->query($sql);
    
    if ($result === TRUE) {
        return ["success" => true];
    } elseif ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        return ["error" => $conn->error];
    }
}

// Handling API requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    
    if (isset($input['query'])) {
        $sql = $input['query'];
        $response = executeQuery($sql);
        echo json_encode($response);
    } else {
        echo json_encode(["error" => "No SQL query provided"]);
    }
}

$conn->close();
?>
