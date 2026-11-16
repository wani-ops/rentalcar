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
$password = ""; // Replace with your actual MySQL password
$dbname = "carrental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['cust_email'];

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM customer WHERE cust_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Fetching the single row directly
} else {
    echo "<p>No results found for the provided email.</p>";
}

$stmt->close();
$conn->close();
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

    <title>User Profile - Rent4u</title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,600,700&display=swap" rel="stylesheet">

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
                        <span>Rent4u</span>
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
                </nav>
            </div>
        </header>
        <!-- end header section -->
    </div>

    <!-- Profile Display Section -->
    <section class="about_section layout_padding-bottom">
        <div class="container">
            <div class="heading_container">
                <h2>User Profile</h2>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="img-box">
                        <img src="images/about-img.png" alt="Profile Image">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="detail-box">
                        <h3><?php echo $row['cust_name']; ?></h3>
                        <ul class="profile-details">
                            <li><strong>ID:</strong> <?php echo $row["cust_id"]; ?></li>
                            <li><strong>IC:</strong> <?php echo $row["cust_ic"]; ?></li>
                            <li><strong>Email:</strong> <?php echo $row["cust_email"]; ?></li>
                            <li><strong>Phone:</strong> <?php echo $row["cust_no"]; ?></li>
                            <li><strong>Address:</strong> <?php echo $row["cust_add"]; ?></li>
                            <li><strong>Password:</strong> <?php echo $row["cust_password"]; ?></li>
                            
                        </ul>
                        <a href="profileedit.php" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Profile Display Section -->

    <!-- footer section -->
    <footer class="container-fluid footer_section">
        <p>
            Copyright &copy; 2024 All Rights Reserved. Design by
            <a href="https://html.design/">Free Html Templates</a>
        </p>
    </footer>
    <!-- footer section -->

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>
