<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars | Rizki Car Rental Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Additional styles can be added here */
    </style>
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
                <a href="profile.php">
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
                <span class="dashboard">Cars Management</span>
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
                <h2>Cars List</h2>
                <div class="table-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Car ID</th>
                                <th>Car Plate</th>
                                <th>Car Model</th>
                                <th>Car Year</th>
                                <th>Fee per Hour</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="car-list">
                            <?php
                            // PHP code to fetch and display cars from database
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "carrental";

                            // Establish database connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // SQL query to fetch cars
                            $sql = "SELECT car_id, car_plate, car_model, car_year, car_fee_perhour, car_status FROM car";
                            $result = $conn->query($sql);

                            // Check if the query executed successfully
                            if ($result === false) {
                                die("Error executing query: " . $conn->error);
                            }

                            // Proceed with fetching rows only if $result is valid
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['car_id'] . "</td>";
                                    echo "<td>" . $row['car_plate'] . "</td>";
                                    echo "<td>" . $row['car_model'] . "</td>";
                                    echo "<td>" . $row['car_year'] . "</td>";
                                    echo "<td>$" . $row['car_fee_perhour'] . "</td>";
                                    echo "<td>" . $row['car_status'] . "</td>";
                                    echo "<td><button onclick='editCar(" . $row['car_id'] . ")'>Edit</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No cars found</td></tr>";
                            }

                            // Close the database connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container" id="edit-car-container" style="display: none;">
                <h2>Edit Car</h2>
                <div class="form-container">
                    <form id="edit-car-form">
                        <input type="hidden" id="edit-car-id" name="edit-car-id">
                        <div class="form-group">
                            <label for="edit-car-plate">Car Plate:</label>
                            <input type="text" id="edit-car-plate" name="edit-car-plate" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-car-model">Car Model:</label>
                            <input type="text" id="edit-car-model" name="edit-car-model" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-car-year">Car Year:</label>
                            <input type="number" id="edit-car-year" name="edit-car-year" min="1900" max="2099" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-car-fee-perhour">Fee per Hour:</label>
                            <input type="number" id="edit-car-fee-perhour" name="edit-car-fee-perhour" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-car-status">Status:</label>
                            <select id="edit-car-status" name="edit-car-status" required>
                                <option value="Available">Available</option>
                                <option value="Booked">Booked</option>
                                <option value="In Service">In Service</option>
                            </select>
                        </div>
                        <div class="form-buttons">
                            <button type="button" id="update-car-btn">Update Car</button>
                            <button type="button" id="cancel-edit-btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="container">
                <h2>Add or Remove Car</h2>
                <div class="form-container">
                    <form id="car-form">
                        <div class="form-group">
                            <label for="car-plate">Car Plate:</label>
                            <input type="text" id="car-plate" name="car-plate" required>
                        </div>
                        <div class="form-group">
                            <label for="car-model">Car Model:</label>
                            <input type="text" id="car-model" name="car-model" required>
                        </div>
                        <div class="form-group">
                            <label for="car-year">Car Year:</label>
                            <input type="number" id="car-year" name="car-year" min="1900" max="2099" required>
                        </div>
                        <div class="form-group">
                            <label for="car-fee-perhour">Fee per Hour:</label>
                            <input type="number" id="car-fee-perhour" name="car-fee-perhour" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="car-status">Status:</label>
                            <select id="car-status" name="car-status" required>
                                <option value="Available">Available</option>
                                <option value="Booked">Booked</option>
                                <option value="In Service">In Service</option>
                            </select>
                        </div>
                        <div class="form-buttons">
                            <button type="button" id="insert-car-btn">Insert Car</button>
                            <button type="button" id="drop-car-btn">Drop Car</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editCar(carId) {
            // Show the edit car form and populate with existing car data
            document.getElementById('edit-car-container').style.display = 'block';

            // Fetch existing car data via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_car.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var carData = JSON.parse(xhr.responseText);
                    document.getElementById('edit-car-id').value = carData.car_id;
                    document.getElementById('edit-car-plate').value = carData.car_plate;
                    document.getElementById('edit-car-model').value = carData.car_model;
                    document.getElementById('edit-car-year').value = carData.car_year;
                    document.getElementById('edit-car-fee-perhour').value = carData.car_fee_perhour;
                    document.getElementById('edit-car-status').value = carData.car_status;
                }
            };
            xhr.send("car_id=" + carId);
        }

        document.getElementById('update-car-btn').addEventListener('click', function() {
            let carId = document.getElementById('edit-car-id').value;
            let carPlate = document.getElementById('edit-car-plate').value.trim();
            let carModel = document.getElementById('edit-car-model').value.trim();
            let carYear = document.getElementById('edit-car-year').value;
            let carFeePerHour = document.getElementById('edit-car-fee-perhour').value.trim();
            let carStatus = document.getElementById('edit-car-status').value;

            if (carPlate && carModel && carYear && carFeePerHour && carStatus) {
                // AJAX call to update car in database
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_car.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText);
                        location.reload(); // Refresh page after update
                    }
                };
                xhr.send("car_id=" + carId + "&car_plate=" + carPlate + "&car_model=" + carModel + "&car_year=" + carYear + "&car_fee_perhour=" + carFeePerHour + "&car_status=" + carStatus);
            } else {
                alert('Please fill out all fields.');
            }
        });

        document.getElementById('cancel-edit-btn').addEventListener('click', function() {
            // Hide the edit car form
            document.getElementById('edit-car-container').style.display = 'none';
        });

        document.getElementById('insert-car-btn').addEventListener('click', function() {
            let carPlate = document.getElementById('car-plate').value.trim();
            let carModel = document.getElementById('car-model').value.trim();
            let carYear = document.getElementById('car-year').value;
            let carFeePerHour = document.getElementById('car-fee-perhour').value.trim();
            let carStatus = document.getElementById('car-status').value;

            if (carPlate && carModel && carYear && carFeePerHour && carStatus) {
                // AJAX call to insert car into database
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "insert_car.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText);
                        location.reload(); // Refresh page after insertion
                    }
                };
                xhr.send("car_plate=" + carPlate + "&car_model=" + carModel + "&car_year=" + carYear + "&car_fee_perhour=" + carFeePerHour + "&car_status=" + carStatus);
            } else {
                alert('Please fill out all fields.');
            }
        });

        document.getElementById('drop-car-btn').addEventListener('click', function() {
            let carPlate = document.getElementById('car-plate').value.trim();

            if (carPlate) {
                // AJAX call to delete car from database
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_car.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText);
                        location.reload(); // Refresh page after deletion
                    }
                };
                xhr.send("car_plate=" + carPlate);
            } else {
                alert('Please provide a car plate number.');
            }
        });

        // Search functionality
        document.getElementById('search-input').addEventListener('input', function() {
            var filter = this.value.toUpperCase();
            var table = document.getElementById('car-list');
            var tr = table.getElementsByTagName('tr');

            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName('td')[1]; // Index of column 'Car Plate'
                if (td) {
                    var plate = td.textContent || td.innerText;
                    if (plate.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        });

    </script>
</body>
</html>
