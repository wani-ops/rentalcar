<?php
// Check if all required fields are set
if (isset($_POST['car_plate'], $_POST['car_model'], $_POST['car_year'], $_POST['car_fee_perhour'], $_POST['car_status'])) {
    $car_plate = $_POST['car_plate'];
    $car_model = $_POST['car_model'];
    $car_year = $_POST['car_year'];
    $car_fee_perhour = $_POST['car_fee_perhour'];
    $car_status = $_POST['car_status'];

    // Validate input (you can add more validation as needed)
    // For example, ensuring car_plate is unique or within a certain format

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

    // Prepare SQL statement to insert car into database
    $sql = "INSERT INTO car (car_plate, car_model, car_year, car_fee_perhour, car_status)
            VALUES ('$car_plate', '$car_model', '$car_year', '$car_fee_perhour', '$car_status')";

    if ($conn->query($sql) === TRUE) {
        echo "Car inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    echo "Please fill out all fields.";
}
?>
