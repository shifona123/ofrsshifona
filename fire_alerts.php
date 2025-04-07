<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ofrs';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Fetch fire alerts
$sql = "SELECT * FROM fire_alerts ORDER BY reporting_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Alerts</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; display: flex; }
        .sidebar { width: 250px; background: #2A3F54; color: white; padding: 20px; min-height: 100vh; }
        .sidebar h2 { text-align: center; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { margin: 15px 0; }
        .sidebar ul li a { color: white; text-decoration: none; display: block; padding: 10px; border-radius: 5px; }
        .sidebar ul li a:hover, .sidebar ul li .active { background: #1C2833; }

        .main-content { flex: 1; padding: 30px; }
        h2 { margin-bottom: 15px; color: #2A3F54; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 12px; text-align: left; }
        th { background: #2A3F54; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
        .btn { background: #2A3F54; color: white; padding: 8px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; }
        .btn:hover { background: #1C2833; }
        .no-data { text-align: center; padding: 20px; font-size: 16px; color: #888; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>OFRS | ADMIN</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="fire_control.php">Fire Control Teams</a></li>
            <li><a href="fire_alerts.php" class="active">Fire Alerts</a></li>
            <li><a href="status.php">Reports</a></li>
            <li><a href="manage_website.php">Manage Website</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Manage Fire Alerts</h2>
        <div class="card">
            <h3>Fire Alert Information</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sno.</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Location</th>
                        <th>Message</th>
                        <th>Reporting Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $sno = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$sno}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['mobile']}</td>
                                <td>{$row['location']}</td>
                                <td>{$row['message']}</td>
                                <td>{$row['reporting_time']}</td>
                                <td><a href='assign_team.php?id={$row['id']}' class='btn'>Assign Team</a></td>
                            </tr>";
                            $sno++;
                        }
                    } else {
                        echo "<tr><td colspan='7' class='no-data'>No Fire Alerts Available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
