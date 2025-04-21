<?php
    session_start();

    if (isset($_SESSION["member_id"])) {
        include("member_header.php");
    } else {
        include("before_login_header.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .about-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 36px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .mission, .team {
            margin-top: 30px;
        }

        .mission h2, .team h2 {
            font-size: 28px;
            color: #555;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="about-container">
        <h1>About Us</h1>
        <p>Welcome to MyTrade, your reliable partner in tracking and managing Forex portfolios. We provide an easy-to-use platform where users can create portfolios, monitor the latest currency pair prices, and achieve their financial goals. Our mission is to make Forex trading information accessible to everyone, regardless of their experience level.</p>

        <div class="mission">
            <h2>Our Mission</h2>
            <p>At MyTrade, we strive to simplify Forex portfolio management for traders of all backgrounds. We believe that by providing a transparent, user-friendly platform, users can better navigate the complex world of Forex trading and make informed decisions. Our focus is on helping our users achieve their financial goals through an efficient and organized approach.</p>
        </div>

        <div class="team">
            <h2>Our Team</h2>
            <p>We are a diverse team of financial experts, software developers, and passionate individuals dedicated to providing the best possible platform for managing Forex portfolios. Our expertise comes together to offer a well-rounded experience that ensures our users have all the tools they need to succeed.</p>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>
