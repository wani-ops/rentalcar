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
if (!isset($_SESSION['cust_id'])) {
    $query = "SELECT cust_id FROM customer WHERE cust_email = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cust_id = $row['cust_id'];
        $_SESSION['cust_id'] = $cust_id;
    } else {
        die("Error: Unable to retrieve customer ID.");
    }
} else {
    $cust_id = $_SESSION['cust_id'];
}

// Fetch reservation and payment details for the customer
$query = "SELECT r.reserve_id, r.pickup_dest, r.date_start, r.time_start, r.date_end, r.time_duration, r.time_start, c.car_model, p.pay_method, p.pay_total, p.pay_date, r.fullAddress 
          FROM reservation r
          JOIN car c ON r.car_id = c.car_id
          JOIN payment p ON r.reserve_id = p.reserve_id
          WHERE r.cust_id = '$cust_id'";
$result = $conn->query($query);

// Check if query executed successfully
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

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
    <style>
        .receipt_card {
            background-color: #ffffff; /* White background */
            color: #2e1b69; /* Text color */
            border: 1px solid #e0e0e0; /* Optional: Border for card */
            border-radius: 8px; /* Optional: Rounded corners */
            padding: 15px; /* Optional: Padding inside the card */
            margin-bottom: 15px; /* Optional: Margin bottom for spacing */
        }

        /* Additional styling for the card title */
        .receipt_card .card-title {
            color: #2e1b69; /* Text color for title */
            font-size: 20px; /* Optional: Adjust font size */
            font-weight: bold; /* Optional: Bold font weight */
            margin-bottom: 10px; /* Optional: Margin bottom for spacing */
        }

        /* Additional styling for the card body */
        .receipt_card .card-body {
            padding: 0; /* Optional: Reset padding for body */
        }

        /* Adjust other form group styles as needed */
        .receipt_card .form-group {
            margin-bottom: 10px; /* Optional: Adjust margin between form groups */
        }

        /* Adjust label styles if necessary */
        .receipt_card label {
            font-weight: bold; /* Optional: Bold label text */
        }

        /* Adjust paragraph styles */
        .receipt_card p {
            margin-bottom: 5px; /* Optional: Margin bottom for paragraphs */
        }
    </style>
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
    <section class="contact_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>Reservation History</h2>
            </div>

            <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="receipt_card">
                        <div class="card-body">
                            <h5 class="card-title">Reservation Details</h5>
                            <div class="form-group">
                                <label>Pickup Destination:</label>
                                <p><?php echo $row['pickup_dest']; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Pickup Delivery:</label>
                                <p><?php echo $row['fullAddress']; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Car Model:</label>
                                <p><?php echo $row['car_model']; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Pickup Date:</label>
                                <p><?php echo $row['date_start']; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Pickup Time:</label>
                                <p><?php echo $row['time_start']; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Return Date:</label>
                                <p><?php echo $row['date_end']; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Duration:</label>
                                <p><?php echo $row['time_duration']; ?></p>
                            </div>
                            <h5 class="card-title">Payment Details</h5>
                            <div class="form-group">
                                <label>Payment Method:</label>
                                <p><?php echo $row['pay_method']; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Total Payment:</label>
                                <p><?php echo $row['pay_total']; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Payment Date:</label>
                                <p><?php echo $row['pay_date']; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php else: ?>
            <p>No reservations found.</p>
            <?php endif; ?>

            <?php $conn->close(); ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer_section">
        <div class="container">
            <p>&copy; <span id="displayYear"></span> All Rights Reserved By Rent4u</p>
        </div>
    </footer>
    <!-- Footer Section -->

    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
</body>
</html>
