<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Separate query for different pickup destinations
// Query for 'carRentalSite' pickup destination
$sqlCarRentalSite = "SELECT r.reserve_id, r.pickup_dest, r.date_start, r.date_end, r.time_duration, r.cust_id, c.cust_name, c.cust_no, r.car_id, r.fullAddress 
                     FROM reservation r
                     JOIN customer c ON r.cust_id = c.cust_id
                     WHERE r.pickup_dest = 'carRentalSite'
                     ORDER BY r.date_start DESC";

// Query for 'delivery' pickup destination
$sqlDelivery = "SELECT r.reserve_id, r.pickup_dest, r.date_start, r.date_end, r.time_duration, r.cust_id, c.cust_name, c.cust_no, r.car_id, r.fullAddress 
                FROM reservation r
                JOIN customer c ON r.cust_id = c.cust_id
                WHERE r.pickup_dest = 'delivery'
                ORDER BY r.date_start DESC";

$resultCarRentalSite = $conn->query($sqlCarRentalSite);
$resultDelivery = $conn->query($sqlDelivery);

if ($resultCarRentalSite === FALSE || $resultDelivery === FALSE) {
  die(json_encode(["error" => "Query failed: " . $conn->error, "sql_query" => [$sqlCarRentalSite, $sqlDelivery]]));
}

// Fetch all rows from the result sets
$reservationsCarRentalSite = $resultCarRentalSite->fetch_all(MYSQLI_ASSOC);
$reservationsDelivery = $resultDelivery->fetch_all(MYSQLI_ASSOC);

// Combine results into a single associative array
$reservations = [
  "carRentalSite" => $reservationsCarRentalSite,
  "delivery" => $reservationsDelivery
];

// Output JSON-encoded data
echo json_encode($reservations);

$conn->close();
?>
