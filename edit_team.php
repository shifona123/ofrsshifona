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

// Check if the team ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Request!");
}

$id = $_GET['id'];

// Fetch team details
$sql = "SELECT * FROM fire_teams WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Team Not Found!");
}

$team = $result->fetch_assoc();

// Handle Update
if (isset($_POST['update_team'])) {
    $team_name = $_POST['team_name'];
    $leader_name = $_POST['leader_name'];
    $leader_contact = $_POST['leader_contact'];
    $team_members = $_POST['team_members'];

    $updateQuery = "UPDATE fire_teams SET 
        team_name='$team_name', leader_name='$leader_name', 
        leader_contact='$leader_contact', team_members='$team_members' 
        WHERE id=$id";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Team Updated Successfully!'); window.location='fire_control.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fire Control Team</title>
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
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        form label { display: block; font-weight: bold; margin-top: 10px; }
        form input, form textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { background: #2A3F54; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 10px; }
        .btn:hover { background: #1C2833; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>OFRS | ADMIN</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="fire_control.php" class="active">Fire Control Teams</a></li>
            <li><a href="fire_alerts.php">Fire Alerts</a></li>
            <li><a href="report.php">Reports</a></li>
            <li><a href="manage_website.php">Manage Website</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Edit Fire Control Team</h2>
        <div class="form-container">
            <form action="edit_team.php?id=<?= $id; ?>" method="POST">
                <label>Team Name</label>
                <input type="text" name="team_name" value="<?= $team['team_name']; ?>" required>

                <label>Team Leader Name</label>
                <input type="text" name="leader_name" value="<?= $team['leader_name']; ?>" required>

                <label>Team Lead Contact Number</label>
                <input type="text" name="leader_contact" value="<?= $team['leader_contact']; ?>" required>

                <label>Team Members (Separated by Comma)</label>
                <textarea name="team_members" required><?= $team['team_members']; ?></textarea>

                <button type="submit" name="update_team" class="btn">Update Team</button>
            </form>
        </div>
    </div>

</body>
</html>
