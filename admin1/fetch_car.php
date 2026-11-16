<?php
// Check if car_id is set in POST request
if (isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carrental";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch car data
    $sql = "SELECT car_id, car_plate, car_model, car_year, car_fee_perhour, car_status FROM car WHERE car_id = $car_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $carData = $result->fetch_assoc();
        echo json_encode($carData);
    } else {
        echo "Car not found.";
    }

    // Close database connection
    $conn->close();
} else {
    echo "Car ID not specified.";
}
?>
