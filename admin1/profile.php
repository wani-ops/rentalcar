<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rizki Car Rental Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class="bx bxs-car"></i>
      <span class="logo_name">Rizki Car Rental</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="admin.html" class="active">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Booking History</span>
        </a>
      </li>
      <li>
        <a href="">
          <i class="bx bx-user"></i>
          <span class="links_name">Users</span>
        </a>
      </li>
      <li>
        <a href="cars.php">
          <i class="bx bx-car"></i>
          <span class="links_name">Cars</span>
        </a>
      </li>
    </ul>
    <div class="log_out">
      <a href="../index1.html">
        <i class="bx bx-log-out"></i>
        <span class="links_name">Log out</span>
      </a>
    </div>
  </div>
  <div class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Booking History</span>
      </div>
      <div class="search-box">
        <input type="text" id="search-input" placeholder="Search...">
        <i class="bx bx-search"></i>
      </div>
      <div class="profile-details">
        <span class="admin_name">Admin</span>
      </div>
    </nav>
    <div class="home-content">
      <div class="container">
        <h2>Customer Profile</h2>
        <div class="profile-sections">
          <div class="section personal-info">
            <h3>Personal Information</h3>
            <p>View customer personal details.</p>
            <form action="profile.php" method="GET">
              <label for="customerName">Customer Name:</label>
              <input type="text" id="customerName" name="cust_name">
              <button type="submit">Get Profile</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cust_name'])) {
              $cust_name = $_GET['cust_name'];

              // Connect to your database
              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "carrental";

              $conn = new mysqli($servername, $username, $password, $dbname);

              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              // Fetch customer details
              $sql_customer = "SELECT * FROM customer WHERE cust_name='$cust_name'";
              $result_customer = $conn->query($sql_customer);

              if ($result_customer->num_rows > 0) {
                // Output data of each row
                while ($row_customer = $result_customer->fetch_assoc()) {
                  echo "<p><strong>Customer ID:</strong> " . $row_customer["cust_id"] . "</p>";
                  echo "<p><strong>Customer Name:</strong> " . $row_customer["cust_name"] . "</p>";
                  echo "<p><strong>Customer Number:</strong> " . $row_customer["cust_no"] . "</p>";
                  echo "<p><strong>Email:</strong> " . $row_customer["cust_email"] . "</p>";
                  echo "<p><strong>Address:</strong> " . $row_customer["cust_add"] . "</p>";
                }

                // Fetch rental history for the customer
                $sql_rental_history = "SELECT * FROM reservation WHERE cust_id=(SELECT cust_id FROM customer WHERE cust_name='$cust_name')";
                $result_rental_history = $conn->query($sql_rental_history);

                if ($result_rental_history->num_rows > 0) {
                  echo "<h3>Rental History</h3>";
                  echo "<table class='table table-bordered'>";
                  echo "<thead><tr><th>Reservation ID</th><th>Pickup Destination</th><th>Start Date</th><th>End Date</th><th>Time Duration</th><th>Car ID</th><th>Delivery Address</th></tr></thead>";
                  echo "<tbody>";

                  // Output rental history details
                  while ($row_rental_history = $result_rental_history->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_rental_history["reserve_id"] . "</td>";
                    echo "<td>" . $row_rental_history["pickup_dest"] . "</td>";
                    echo "<td>" . $row_rental_history["date_start"] . "</td>";
                    echo "<td>" . $row_rental_history["date_end"] . "</td>";
                    echo "<td>" . $row_rental_history["time_duration"] . "</td>";
                    echo "<td>" . $row_rental_history["car_id"] . "</td>";
                    echo "<td>" . $row_rental_history["fullAddress"] . "</td>";
                    echo "</tr>";
                  }

                  echo "</tbody></table>";
                } else {
                  echo "<p>No rental history found for '$cust_name'</p>";
                }
              } else {
                echo "<p>No results found for '$cust_name'</p>";
              }

              $conn->close();
            }
            ?>
          </div>
          
          <div class="section rental-history">
         
            <!-- You can add rental history display logic here -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.getElementById('search-input').addEventListener('keyup', function () {
        let searchValue = this.value.toLowerCase();
        let tableRows = document.querySelectorAll('#reservation-tbody tr');

        tableRows.forEach(row => {
          let rowText = row.innerText.toLowerCase();
          if (rowText.includes(searchValue)) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
      });
    });
  </script>
</body>
</html>
