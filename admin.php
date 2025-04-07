<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ofrs';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: linear-gradient(to right, #3366FF, #3399FF); display: flex; align-items: center; justify-content: center; height: 100vh; }

        .container { display: flex; background: white; width: 800px; border-radius: 10px; overflow: hidden; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); }

        .left { flex: 1; background: url('fire-alert.jpg') no-repeat center center/cover; }

        .right { flex: 1; padding: 40px; text-align: center; }
        
        .logo { width: 80px; margin-bottom: 10px; }
        h2 { font-size: 22px; margin-bottom: 20px; }

        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }

        .btn { background: #3366FF; color: white; padding: 10px; width: 100%; border: none; cursor: pointer; font-size: 16px; border-radius: 5px; }
        .btn:hover { background: #0033CC; }

        .error { color: red; font-size: 14px; margin-top: 10px; }

        .links { margin-top: 10px; }
        .links a { text-decoration: none; color: #3366FF; font-size: 14px; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="container">
        <div class="left"></div>

        <div class="right">
            <img src="fire-icon.png" class="logo" alt="OFRS Logo">
            <h2>Welcome Back!</h2>

            <form action="admin.php" method="POST">
                <input type="text" name="username" placeholder="Enter username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn">Login</button>
                <?php if ($error) echo "<p class='error'>$error</p>"; ?>
            </form>

            <div class="links">
                <a href="#">Forgot Password?</a><br>
                <a href="index.php">🏠 Home Page</a>
            </div>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>
