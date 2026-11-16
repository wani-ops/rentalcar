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

// Handle form submission for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs (implement as needed)

    // Update user's profile information
    $name = $_POST['name'];
    $ic = $_POST['ic'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $email = $_SESSION['cust_email'];

    // Prepare statement
    $stmt = $conn->prepare("UPDATE customer SET cust_name=?, cust_ic=?, cust_no=?, cust_add=?, cust_password=? WHERE cust_email=?");
    $stmt->bind_param("ssssss", $name, $ic, $phone, $address, $password, $email);

    // Execute the update query
    if ($stmt->execute()) {
        // Redirect to profile display page after successful update
        header('Location: profiledisplay.php');
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $stmt->close();
}

// Fetch current user data for pre-filling the form
$email = $_SESSION['cust_email'];
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

    <title>Edit Profile - Rent4u</title>

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
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->
    </div>

    <!-- Profile Edit Section -->
    <section class="about_section layout_padding-bottom">
        <div class="container">
            <div class="heading_container">
                <h2>Edit Profile</h2>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="img-box">
                        <img src="images/about-img.png" alt="Profile Image">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="detail-box">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['cust_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="ic">IC</label>
                                <input type="text" class="form-control" id="ic" name="ic" value="<?php echo $row['cust_ic']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['cust_no']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['cust_add']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['cust_password']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Profile Edit Section -->

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
