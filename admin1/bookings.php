<?php
// Database connection parameters
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "reservation"; // Update database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve recent bookings (adjust query as per your table structure)
$sql = "SELECT * FROM bookings ORDER BY booking_date DESC LIMIT 5";

$result = $conn->query($sql);

$bookings = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

// Close connection
$conn->close();

// Return JSON encoded data
header('Content-Type: application/json');
echo json_encode($bookings);
?>
