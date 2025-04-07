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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $incident_type = $_POST['incident_type'];
    $description = $_POST['description'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $sql = "INSERT INTO reports (name, mobile, incident_type, description, latitude, longitude) 
            VALUES ('$name', '$mobile', '$incident_type', '$description', '$latitude', '$longitude')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Report Submitted Successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch latest reports
$fetchReports = "SELECT * FROM reports ORDER BY created_at DESC LIMIT 5";
$reports = $conn->query($fetchReports);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fire Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; }

        .navbar { background: #1a1a1a; padding: 15px 5%; display: flex; justify-content: space-between; }
        .navbar .logo { color: white; font-size: 22px; font-weight: bold; display: flex; align-items: center; }
        .navbar ul { list-style: none; display: flex; }
        .navbar ul li { margin: 0 15px; }
        .navbar ul li a { color: white; text-decoration: none; }
        .navbar ul li a:hover { text-decoration: underline; }

        .hero { text-align: center; margin: 20px; }
        .hero img { max-width: 80%; border-radius: 10px; }

        .container { max-width: 800px; background: white; padding: 20px; margin: auto; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .container h2 { margin-bottom: 15px; }
        .form-group { margin-bottom: 10px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group textarea { height: 80px; }
        .btn { background: blue; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: darkblue; }

        #map { width: 100%; height: 300px; margin-top: 10px; border-radius: 8px; }

        .reports { max-width: 800px; margin: auto; margin-top: 20px; }
        .reports h3 { margin-bottom: 10px; }
        .report-item { background: white; padding: 10px; border-radius: 5px; margin-bottom: 10px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1); }

        .footer { background: #1a1a1a; color: white; text-align: center; padding: 15px; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <img src="fire-icon.png" alt="Fire Icon" width="25" style="margin-right: 8px;">
            OFRS
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="report.php" class="active">Reporting</a></li>
            <li><a href="status.php">View Status</a></li>
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </div>

    <div class="hero">
        <img src="fire-report-image.png" alt="Fire Reporting">
    </div>

    <div class="container">
        <h2>Online Fire Report</h2>
        <form action="report.php" method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="text" name="mobile" required>
            </div>
            <div class="form-group">
                <label>Incident Type</label>
                <select name="incident_type" required>
                    <option value="Building Fire">Building Fire</option>
                    <option value="Forest Fire">Forest Fire</option>
                    <option value="Vehicle Fire">Vehicle Fire</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label>Location (Select on Map)</label>
                <div id="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.721575737896!2d77.73624597477674!3d8.717967091331495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b04120419c83ac9%3A0x99c29bb2b7fbfc30!2sSt.Xavier&#39;s%20College!5e0!3m2!1sen!2sin!4v1742110062875!5m2!1sen!2sin" width="600" height="280" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>

    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), { center: { lat: 0, lng: 0 }, zoom: 2 });
        }
    </script>

</body>
</html>
