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

    // Prepare SQL statement to delete car from database
    $sql = "DELETE FROM car WHERE car_id = $car_id";

    if ($conn->query($sql) === TRUE) {
        echo "Car removed successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    echo "Car ID not specified.";
}
?>
