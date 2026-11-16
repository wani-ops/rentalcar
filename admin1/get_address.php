<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrental";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// SQL query to retrieve data from the reservation table along with customer details
$sql = "SELECT r.reserve_id, r.fullAddress 
        FROM reservation r";
$result = $conn->query($sql);

if ($result === FALSE) {
  die(json_encode(["error" => "Query failed: " . $conn->error]));
}

// Check if there are results and output data as JSON
$addresses = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $addresses[] = $row;
  }
  echo json_encode($addresses);
} else {
  echo json_encode([]);
}
$conn->close();
?>
