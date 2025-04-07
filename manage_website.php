<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ofrs';

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current website settings
$query = "SELECT * FROM website_settings WHERE id = 1"; // Assuming settings are stored in a single row
$result = $conn->query($query);
$site = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['website_title'];
    
    // Handle file upload
    if (!empty($_FILES['website_logo']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["website_logo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["website_logo"]["tmp_name"], $target_file)) {
                $logo = $target_file;

                // Update database
                $sql = "UPDATE website_settings SET title = '$title', logo = '$logo' WHERE id = 1";
                $conn->query($sql);
                echo "<script>alert('Website updated successfully!'); window.location.href='manage_website.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid file format! Only jpg, jpeg, png, gif allowed.');</script>";
        }
    } else {
        // Update only title
        $sql = "UPDATE website_settings SET title = '$title' WHERE id = 1";
        $conn->query($sql);
        echo "<script>alert('Website title updated successfully!'); window.location.href='manage_website.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Website</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f8f9fc; }
        
        .sidebar { width: 250px; height: 100vh; background: #2a52be; color: white; position: fixed; padding: 20px; }
        .sidebar h2 { font-size: 22px; text-align: center; margin-bottom: 20px; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { padding: 10px; margin-bottom: 5px; border-radius: 5px; }
        .sidebar ul li a { color: white; text-decoration: none; display: block; }
        .sidebar ul li:hover { background: #1d3e9b; }

        .content { margin-left: 260px; padding: 20px; }
        .header { background: white; padding: 15px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .header h2 { margin: 0; font-size: 20px; }
        .header img { width: 30px; border-radius: 50%; }

        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1); margin-top: 20px; }
        .card h3 { margin-bottom: 15px; }

        .form-group { margin-bottom: 15px; }
        .form-group label { font-weight: bold; display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group input[type="file"] { border: none; }

        .btn { background: #2a52be; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%; }
        .btn:hover { background: #1d3e9b; }

        .footer { margin-top: 20px; text-align: center; font-size: 14px; color: #666; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>OFRS | ADMIN</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="fire_teams.php">Fire Control Teams</a></li>
            <li><a href="fire_alerts.php">Fire Alerts</a></li>
            <li><a href="status.php">Reports</a></li>
            <li style="background: #1d3e9b;"><a href="manage_website.php">Manage Website</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h2>Manage Website</h2>
            <img src="<?= $site['logo'] ?>" alt="Admin">
        </div>

        <div class="card">
            <h3>Manage Website</h3>
            <form action="manage_website.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Current Logo</label><br>
                    <img src="<?= $site['logo'] ?>" alt="Logo" width="100">
                </div>
                <div class="form-group">
                    <label>Website Title</label>
                    <input type="text" name="website_title" value="<?= $site['title'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Website Logo</label>
                    <input type="file" name="website_logo">
                    <small style="color: red;">Only jpg / jpeg / png / gif format allowed.</small>
                </div>
                <button type="submit" class="btn">Update</button>
            </form>
        </div>

        <div class="footer">
            Copyright © OFRS
        </div>
    </div>

</body>
</html>
