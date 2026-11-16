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

// If the login form is submitted

// Initialize session
session_start();

if (isset($_POST['login'])) {
    /* capture values from HTML form */
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM customer WHERE cust_email= ? AND cust_password= ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->num_rows;

    if ($row == 0) {
        // Jump to indexwrong page
        header('Location: indexwrong.html'); 
    } else {
        $r = $result->fetch_assoc();
        $level = $r['level_id'];

        // Auto-generate level_id if not already set
        if ($level == null) {
            if (strpos($email, '@admindomain.com') !== false) {
                $level = 1; // admin
            } else {
                $level = 2; // user
            }

            // Update level_id in database
            $updateStmt = $conn->prepare("UPDATE customer SET level_id = ? WHERE cust_email = ?");
            $updateStmt->bind_param("is", $level, $email);
            $updateStmt->execute();
            $updateStmt->close();
        }

        $_SESSION['cust_email'] = $r['cust_email'];

        if ($level == 1) { 
            // Jump to secured page
            header('Location: ../admin1/admin.html'); 
        } elseif ($level == 2) {
            // Jump to secured page
            header('Location: ../user');
        } else {
            header('Location: index.html');
        }
    }

    $stmt->close();
}

$conn->close();
?>
