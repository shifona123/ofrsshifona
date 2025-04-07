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

// Fetch latest reports
$sql = "SELECT * FROM reports ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Report Status</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; }
        
        .navbar { background: #1a1a1a; color: white; padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; }
        .navbar img { height: 40px; margin-right: 10px; }
        .navbar a { color: white; text-decoration: none; margin: 0 15px; font-size: 16px; }
        .navbar a:hover { text-decoration: underline; }

        .container { max-width: 900px; background: white; padding: 20px; margin: 20px auto; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); text-align: center; }
        .container h2 { margin-bottom: 15px; font-size: 24px; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #333; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }

        .footer { background: #1a1a1a; color: white; text-align: center; padding: 15px; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="navbar">
        <div>
            <img src="fire-icon.png" alt="Logo"> 
            <b>OFRS</b>
        </div>
        <div>
            <a href="index.php">Home</a>
            <a href="report.php">Reporting</a>
            <a href="status.php">View Status</a>
            <a href="admin.php">Admin</a>
        </div>
    </div>

    <div class="container">
        <h2>Fire Report Status</h2>

        <table>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Incident Type</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['incident_type']}</td>
                        <td>{$row['description']}</td>
                        <td>Lat: {$row['latitude']}, Lng: {$row['longitude']}</td>
                        <td>{$row['created_at']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="footer">
        <p>OFRS 2025</p>
    </div>

</body>
</html>

<?php $conn->close(); ?>
