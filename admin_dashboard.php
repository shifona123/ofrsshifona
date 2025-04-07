<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch dashboard statistics
$sql = "SELECT 
            (SELECT COUNT(*) FROM fire_reports WHERE status='New') AS new_requests,
            (SELECT COUNT(*) FROM fire_reports) AS total_reports,
            (SELECT COUNT(*) FROM fire_reports WHERE status='Completed') AS completed,
            (SELECT COUNT(*) FROM fire_reports WHERE status='Assigned') AS assigned,
            (SELECT COUNT(*) FROM fire_reports WHERE status='On The Way') AS on_the_way,
            (SELECT COUNT(*) FROM fire_reports WHERE status='In Progress') AS in_progress";

$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - OFRS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #3756F7;
            color: white;
            position: fixed;
            padding: 20px;
            box-shadow: 2px 0px 10px rgba(0,0,0,0.1);
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
        }
        .sidebar ul li:hover {
            background-color: #273bc7;
        }
        .main {
            margin-left: 270px;
            padding: 20px;
        }
        .dashboard-cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            width: 250px;
            text-align: center;
        }
        .card h3 {
            margin-bottom: 10px;
        }
        .red { border-left: 5px solid red; }
        .blue { border-left: 5px solid blue; }
        .green { border-left: 5px solid green; }
        .orange { border-left: 5px solid orange; }
        .purple{ border-left: 5px solid purple; }
        .pink{ border-left: 5px solid pink; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>OFRS | Admin</h2>
        <ul>
            <li><a href="admin_dashboard.php" class="active" style="color:white; text-decoration: none;">Dashboard</a></li>
            <li><a href="fire_control.php" style="color:white; text-decoration: none;">Fire Control Teams</a></li>
            <li><a href="fire_alerts.php" style="color:white; text-decoration: none;">Fire Alerts</a></li>
            <li><a href="status.php" style="color:white; text-decoration: none;">Reports</a></li>
            <li><a href="manage_website.php" style="color:white; text-decoration: none;">Manage Website</a></li>
            <li><a href="logout.php" style="color:white; text-decoration: none;">Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <h1>Dashboard</h1>
        <div class="dashboard-cards">
            <div class="card red">
                <h3>New Fire Requests</h3>
                <p><?php echo $data['new_requests']; ?></p>
            </div>
            <div class="card blue">
                <h3>Total Fire Reports</h3>
                <p><?php echo $data['total_reports']; ?></p>
            </div>
            <div class="card green">
                <h3>Fire Requests Completed</h3>
                <p><?php echo $data['completed']; ?></p>
            </div>
            <div class="card purple">
                <h3>Assigned Fire Requests</h3>
                <p><?php echo $data['assigned']; ?></p>
            </div>
            <div class="card orange">
                <h3>Team On The Way</h3>
                <p><?php echo $data['on_the_way']; ?></p>
            </div>
            <div class="card pink">
                <h3>Fire Relief Work In Progress</h3>
                <p><?php echo $data['in_progress']; ?></p>
            </div>
        </div>
        <p style="text-align:center; margin-top:20px;">Copyright © OFRS</p>
    </div>

</body>
</html>
