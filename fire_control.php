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

// Handle form submission (Add Team)
if (isset($_POST['add_team'])) {
    $team_name = $_POST['team_name'];
    $leader_name = $_POST['leader_name'];
    $leader_contact = $_POST['leader_contact'];
    $team_members = $_POST['team_members'];

    $sql = "INSERT INTO fire_teams (team_name, leader_name, leader_contact, team_members) 
            VALUES ('$team_name', '$leader_name', '$leader_contact', '$team_members')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Fire Control Team Added Successfully!'); window.location='fire_control.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Delete Team
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM fire_teams WHERE id=$id");
    echo "<script>alert('Team Deleted!'); window.location='fire_control.php';</script>";
}

// Handle Edit Team
if (isset($_POST['edit_team'])) {
    $id = $_POST['team_id'];
    $team_name = $_POST['team_name'];
    $leader_name = $_POST['leader_name'];
    $leader_contact = $_POST['leader_contact'];
    $team_members = $_POST['team_members'];

    $sql = "UPDATE fire_teams SET 
            team_name='$team_name', leader_name='$leader_name', leader_contact='$leader_contact', 
            team_members='$team_members' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Team Updated Successfully!'); window.location='fire_control.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch teams
$fetchTeams = "SELECT * FROM fire_teams ORDER BY created_at DESC";
$teams = $conn->query($fetchTeams);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Control Teams</title>
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
        .form-container, .team-table { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        form label { display: block; font-weight: bold; margin-top: 10px; }
        form input, form textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { background: #2A3F54; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 10px; }
        .btn:hover { background: #1C2833; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background: #2A3F54; color: white; }
        .edit, .delete { padding: 5px 10px; border: none; cursor: pointer; }
        .edit { background: #FFA500; color: white; }
        .delete { background: red; color: white; }
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
            <li><a href="status.php">Reports</a></li>
            <li><a href="manage_website.php">Manage Website</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="main-content">
        <h2>Fire Safety Team Creation</h2>
        <div class="form-container">
            <form action="fire_control.php" method="POST">
                <label>Team Name</label>
                <input type="text" name="team_name" required>
                <label>Team Leader Name</label>
                <input type="text" name="leader_name" required>
                <label>Team Lead Contact Number</label>
                <input type="text" name="leader_contact" required>
                <label>Team Members (Separated by Comma)</label>
                <textarea name="team_members" required></textarea>
                <button type="submit" name="add_team" class="btn">Submit</button>
            </form>
        </div>

        <h2>Manage Fire Control Teams</h2>
        <div class="team-table">
            <table>
                <tr>
                    <th>Team Name</th>
                    <th>Leader</th>
                    <th>Contact</th>
                    <th>Members</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $teams->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['team_name']; ?></td>
                        <td><?= $row['leader_name']; ?></td>
                        <td><?= $row['leader_contact']; ?></td>
                        <td><?= $row['team_members']; ?></td>
                        <td>
                            <a href="edit_team.php?id=<?= $row['id']; ?>" class="edit">Edit</a>
                            <a href="fire_control.php?delete=<?= $row['id']; ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>
</html>
