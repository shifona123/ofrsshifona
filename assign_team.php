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

// Get fire alert ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Fire Alert ID.");
}

$alert_id = $_GET['id'];

// Fetch fire alert details
$sql_alert = "SELECT * FROM fire_alerts WHERE id = ?";
$stmt_alert = $conn->prepare($sql_alert);
$stmt_alert->bind_param("i", $alert_id);
$stmt_alert->execute();
$result_alert = $stmt_alert->get_result();
$fire_alert = $result_alert->fetch_assoc();

if (!$fire_alert) {
    die("Fire Alert Not Found.");
}

// Fetch available fire control teams
$sql_teams = "SELECT * FROM fire_control_teams WHERE status = 'Available'";
$result_teams = $conn->query($sql_teams);

// Assign team logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_id = $_POST['team_id'];

    if (!empty($team_id)) {
        // Insert assignment into database
        $sql_assign = "INSERT INTO assigned_requests (fire_alert_id, team_id, assigned_time) VALUES (?, ?, NOW())";
        $stmt_assign = $conn->prepare($sql_assign);
        $stmt_assign->bind_param("ii", $alert_id, $team_id);

        if ($stmt_assign->execute()) {
            // Update team status to "Busy"
            $sql_update_team = "UPDATE fire_control_teams SET status = 'Busy' WHERE id = ?";
            $stmt_update_team = $conn->prepare($sql_update_team);
            $stmt_update_team->bind_param("i", $team_id);
            $stmt_update_team->execute();

            echo "<script>alert('Team assigned successfully!'); window.location='fire_alerts.php';</script>";
        } else {
            echo "<script>alert('Failed to assign team.');</script>";
        }
    } else {
        echo "<script>alert('Please select a team.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Fire Control Team</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); width: 400px; }
        h2 { color: #2A3F54; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        select, button { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd; }
        button { background: #2A3F54; color: white; cursor: pointer; }
        button:hover { background: #1C2833; }
        .btn-back { display: block; text-align: center; margin-top: 10px; text-decoration: none; color: #2A3F54; }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h2>Assign Fire Control Team</h2>
    
    <p><strong>Fire Alert ID:</strong> <?= $fire_alert['id']; ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($fire_alert['location']); ?></p>
    <p><strong>Message:</strong> <?= htmlspecialchars($fire_alert['message']); ?></p>

    <form method="post">
        <div class="form-group">
            <label for="team_id">Select Fire Control Team:</label>
            <select name="team_id" id="team_id" required>
                <option value="">-- Select Team --</option>
                <?php while ($team = $result_teams->fetch_assoc()) { ?>
                    <option value="<?= $team['id']; ?>"><?= htmlspecialchars($team['team_name']); ?> (<?= htmlspecialchars($team['contact_number']); ?>)</option>
                <?php } ?>
            </select>
        </div>

        <button type="submit">Assign Team</button>
    </form>

    <a href="fire_alerts.php" class="btn-back">Back to Fire Alerts</a>
</div>

</body>
</html>
