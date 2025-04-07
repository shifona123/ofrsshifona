<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OFRS - Home</title>
    <link rel="icon" type="image/png" href="fire-icon.png">
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Header Styling */
        .navbar {
            background: #1a1a1a;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            color: white;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar .logo img {
            width: 25px;
            margin-right: 8px;
        }

        .navbar ul {
            list-style: none;
            display: flex;
        }

        .navbar ul li {
            margin: 0 15px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        .active {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            max-width: 1200px;
            margin: auto;
        }

        .hero img {
            max-width: 600px;
            border-radius: 10px;
        }

        .hero-content {
            margin-left: 40px;
        }

        .hero-content h1 {
            font-size: 28px;
            color: #222;
        }

        .hero-content p {
            font-size: 16px;
            color: #444;
            margin-top: 10px;
        }

        .hero-content .btn {
            margin-top: 15px;
            display: inline-block;
            background: blue;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .hero-content .btn:hover {
            background: darkblue;
        }

        /* Fire Safety Section */
        .fire-safety {
            background: #666;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }

        /* Footer */
        .footer {
            background: #1a1a1a;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <img src="fire-icon.png" alt="Fire Icon">
            OFRS
        </div>
        <ul>
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="report.php">Reporting</a></li>
            <li><a href="status.php">View Status</a></li>
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <img src="firefighters.png" alt="Firefighters">
        <div class="hero-content">
            <h1>Emergency Reporting of Fire</h1>
            <p>
                Together, we continue to empower first responders with data and insights that drive quality and performance improvements across the entire health and public safety spectrum.
            </p>
            <a href="report.php" class="btn">Fire Reporting</a>
        </div>
    </div>

    <!-- Fire Safety Section -->
    <div class="fire-safety">
        Fire safety is the set of practices intended to reduce the destruction caused by fire. Fire safety measures include those that are intended to prevent ignition of an uncontrolled fire, and those that are used to limit the development and effects of a fire after it starts.
    </div>

    <!-- Footer -->
    <div class="footer">
        OFRS 2025
    </div>

</body>
</html>
