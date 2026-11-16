<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['cust_email'])) {
    header('Location: index.html');
    exit();
}

// Database connection details
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

$email = $_SESSION['cust_email'];

// Retrieve cust_id from session or database (assuming it's stored in session)
$query = "SELECT cust_id FROM customer WHERE cust_email = '$email'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cust_id = $row['cust_id'];
    $_SESSION['cust_id'] = $cust_id; // Store cust_id in session for future requests
} else {
    // Handle case where cust_id cannot be retrieved
    die("Error: Unable to retrieve customer ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $bookingDate = $_POST['bookingDate'];
    $bookingTime = $_POST['bookingTime'];
    $pickupDestination = $_POST['pickupDestination'];
    $fullAddress = isset($_POST['fullAddress']) ? $_POST['fullAddress'] : '';
    $carOption = $_POST['carOption'];
    $duration = $_POST['duration'];
    $paymentMethod = $_POST['paymentMethod'];
    $licensePicture = $_FILES['licensePicture']['name'];
    $receipt = $_FILES['receipt']['name'];

    // Calculate start and end dates
    $date_start = $bookingDate;
    $time_start = $bookingTime;
    $datetime_start = $date_start . ' ' . $time_start;
    $time_duration = $duration . ':00:00';
    $datetime_end = date('Y-m-d H:i:s', strtotime($datetime_start . ' + ' . $duration . ' hours'));

    // Prepare and execute reservation insertion query
    $carOptionSafe = $conn->real_escape_string($carOption);
    $insert_reservation = "INSERT INTO reservation (pickup_dest, date_start, date_end, time_duration, cust_id, car_id, time_start, fullAddress) 
                           VALUES ('$pickupDestination', '$datetime_start', '$datetime_end', '$time_duration', '$cust_id', 
                           (SELECT car_id FROM car WHERE car_model = '$carOptionSafe'), '$time_start', '$fullAddress')";

    if ($conn->query($insert_reservation) === TRUE) {
        $reserve_id = $conn->insert_id; // Get the last inserted reservation ID

        // Insert payment data
        $pay_total = $duration * 12; // Calculate total price
        $pay_date = date('Y-m-d');
        $insert_payment = "INSERT INTO payment (pay_method, pay_total, pay_date, reserve_id) 
                           VALUES ('$paymentMethod', '$pay_total', '$pay_date', '$reserve_id')";
        if ($conn->query($insert_payment) === TRUE) {
            // Close connection
            $conn->close();

            // Redirect to success page or display success message
            header("Location: success.html");
            exit();
        } else {
            echo "Error inserting payment data: " . $conn->error;
        }
    } else {
        echo "Error inserting reservation data: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Rent4u</title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- fonts style -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,600,700&display=swap"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
    <div class="hero_area">
        <!-- header section starts -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <a class="navbar-brand" href="index.html">
                        <span>
                            Rent4u
                        </span>
                    </a>

                    <div class="navbar-collapse" id="">
                        <div class="user_option">
                        <a href="../login_signup/logout_user_page.php">Log Out</a>
                        </div>
                        <div class="custom_menu-btn">
                            <button onclick="openNav()">
                                <span class="s-1"> </span>
                                <span class="s-2"> </span>
                                <span class="s-3"> </span>
                            </button>
                        </div>
                        <div id="myNav" class="overlay">
                        <div class="overlay-content">
                <a href="index.html">Home</a>
                <a href="profiledisplay.php">Profile</a>
                <a href="profileedit.php">Update Profile</a>
                <a href="rent.php">Reservation</a>
                <a href="rentalhistory.php">Rental History</a>
                <a href="../login_signup/logout_user_page.php">Log Out</a>
              </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->
    </div>

    <!-- Rental Information Section -->
    <section class="contact_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>Rent Information</h2>
            </div>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="form_container">
                        <form action="rent.php" method="post" enctype="multipart/form-data">
                    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="bookingDate">Booking Date</label>
                                    <input type="date" class="form-control" id="bookingDate" name="bookingDate"
                                        required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bookingTime">Booking Time</label>
                                    <input type="time" class="form-control" id="bookingTime" name="bookingTime"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pickupDestination">Pickup Destination</label>
                                <select id="pickupDestination" name="pickupDestination" class="form-control" required>
                                    <option value="carRentalSite">Car Rental Site</option>
                                    <option value="delivery">Delivery</option>
                                </select>
                            </div>
                            <div id="deliveryAddress" style="display: none;" class="form-group">
                                <label for="fullAddress">Full Address</label>
                                <input type="text" id="fullAddress" name="fullAddress" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="carOption">Car Option</label>
                                <select class="form-control" id="carOption" name="carOption" required>
                                    <option value="myvi">Myvi</option>
                                    <option value="axia">Axia</option>
                                    <option value="saga">Saga</option>
                                    <option value="bezza">Bezza</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration (hours)</label>
                                <input type="number" class="form-control" id="duration" name="duration" min="1"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="paymentMethod">Payment Method</label>
                                <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                                    <option value="">Select payment method</option>
                                    <option value="onlineBanking">Online Banking</option>
                                </select>
                            </div>
                            <div id="bankDetails">
                                <p>Account Number: 04114031106</p>
                                <p>Bank Name: Bank Islam</p>
                                <p>Name: NURUL SALWANI BINTI MOHD FADILLAH</p>
                            </div>
                            <div class="form-group">
                                <label for="licensePicture">License Picture</label>
                                <input type="file" class="form-control-file" id="licensePicture" name="licensePicture"
                                    accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="receipt">Receipt</label>
                                <input type="file" class="form-control-file" id="receipt" name="receipt"
                                    accept="image/*" required>
                            </div>
                            <p id="totalPrice">Total Price: RM 0</p>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Rental Information Section -->

    <!-- footer section -->
    <footer class="container-fluid footer_section">
        <p>
            Copyright &copy; 2020 All Rights Reserved. Design by
            <a href="https://html.design/">Free Html Templates</a>
        </p>
    </footer>
    <!-- footer section -->

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>

    <script>
        document.getElementById("pickupDestination").addEventListener("change", function () {
            var deliveryAddress = document.getElementById("deliveryAddress");
            if (this.value === "delivery") {
                deliveryAddress.style.display = "block";
                document.getElementById("fullAddress").required = true;
            } else {
                deliveryAddress.style.display = "none";
                document.getElementById("fullAddress").required = false;
            }
        });

        document.getElementById("duration").addEventListener("input", calculateTotalPrice);
        document.getElementById("carOption").addEventListener("change", calculateTotalPrice);

        function calculateTotalPrice() {
            var duration = document.getElementById("duration").value;
            var carOption = document.getElementById("carOption").value;
            var totalPrice = duration * 12; // RM 12 per hour

            document.getElementById("totalPrice").textContent = "Total Price: RM " + totalPrice.toFixed(2);
        }
    </script>

</body>

</html>
