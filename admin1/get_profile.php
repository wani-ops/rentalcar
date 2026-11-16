<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrental"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if cust_name is set in GET request
if (isset($_GET['cust_name'])) {
    $cust_name = $_GET['cust_name'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT cust_id, cust_ic, cust_name, cust_email, cust_password, cust_no, cust_add, level_id FROM customer WHERE cust_name = ?");
    $stmt->bind_param("s", $cust_name);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output data of each row in HTML format
        echo "<table class='profile-table'>";
        echo "<thead><tr><th>ID</th><th>IC</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>Address</th><th>Level ID</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["cust_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cust_ic"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cust_name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cust_email"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cust_password"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cust_no"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["cust_add"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["level_id"]) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No results found for the customer name provided.</p>";
    }

    // Close statement
    $stmt->close();
} else {
    echo "<p>Please provide a customer name to search.</p>";
}

// Close connection
$conn->close();
?>

