<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "carrental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT car_model, car_plate, car_year, car_fee_perhour FROM car";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="car_details_section layout_padding">
    <div class="container">
        <h2>Available Cars</h2>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="car_detail">';
                echo '<h3>Car Model: ' . htmlspecialchars($row["car_model"]) . '</h3>';
                echo '<p><strong>Car Plate:</strong> ' . htmlspecialchars($row["car_plate"]) . '</p>';
                echo '<p><strong>Year:</strong> ' . htmlspecialchars($row["car_year"]) . '</p>';
                echo '<p><strong>Rental Fee:</strong> RM ' . htmlspecialchars($row["car_fee_perhour"]) . '/hour</p><br>';
                echo '</div>';
            }
        } else {
            echo '<p>No cars available.</p>';
        }
        $conn->close();
        ?>
        <div class="return_button_container">
            <a href="../index1.html" class="return_button">Return to Main Page</a>
        </div>
    </div>
</section>

</body>
</html>
