<?php
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

// If the sign-up form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Retrieve form data
    $cust_ic = $_POST['cust_ic'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // User's chosen password
    $cust_no = $_POST['cust_no'];
    $cust_add = $_POST['cust_add'];

    // No need to hash the password since the user has chosen it directly

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO customer (cust_ic, cust_name, cust_email, cust_password, cust_no, cust_add) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssis", $cust_ic, $fullname, $email, $password, $cust_no, $cust_add);

    if ($stmt->execute()) {
        // Redirect to another page after successful signup
        header("Location: login_signup.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
