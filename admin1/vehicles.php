<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "carrental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of vehicles
$sql_total_vehicles = "SELECT COUNT(*) AS total_vehicles FROM vehicles";
$result_total_vehicles = $conn->query($sql_total_vehicles);
$total_vehicles = 0;

if ($result_total_vehicles->num_rows > 0) {
    $row_total_vehicles = $result_total_vehicles->fetch_assoc();
    $total_vehicles = $row_total_vehicles["total_vehicles"];
}

// Fetch vehicle IDs, models, and statuses
$sql_vehicles = "SELECT vehicle_id, vehicle_model, vehicle_status FROM vehicles";
$result_vehicles = $conn->query($sql_vehicles);

// Close connection
$conn->close();
?>