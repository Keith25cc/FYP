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
    <title>Privacy Policy</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .privacy-container {
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

        h2 {
            color: #555;
            font-size: 24px;
            margin-top: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="privacy-container">
        <h1>Privacy Policy</h1>
        <p>At MyTrade, we value your privacy and are committed to protecting your personal information. This Privacy Policy outlines the type of information we collect, how we use it, and the measures we take to ensure your data is kept secure.</p>

        <h2>Information We Collect</h2>
        <p>We collect personal information such as your name, email address, and any feedback or messages you provide when you contact us. Additionally, we may collect non-personal data such as IP addresses and browser details to improve our services.</p>

        <h2>How We Use Your Information</h2>
        <p>Your personal information is used to respond to your inquiries, provide customer support, and improve our platform. We may also use your data to send important updates regarding our services, if necessary.</p>

        <h2>Data Security</h2>
        <p>We implement appropriate technical and organizational measures to safeguard your personal information. Access to your data is restricted to authorized personnel only, and we strive to ensure that your information is kept secure and confidential.</p>

        <h2>Third-Party Sharing</h2>
        <p>We do not sell or share your personal information with third parties, except when required by law or with your explicit consent. We may, however, share non-personal, aggregated data with third parties to enhance our services.</p>

        <h2>Your Rights</h2>
        <p>You have the right to access, correct, or request the deletion of your personal information. If you wish to exercise these rights, please contact us, and we will assist you in accordance with applicable laws.</p>

        <h2>Changes to This Policy</h2>
        <p>We may update our Privacy Policy from time to time. Any changes will be posted on this page, and we encourage you to review this policy periodically to stay informed about how we are protecting your information.</p>

        <h2>Contact Us</h2>
        <p>If you have any questions or concerns about our Privacy Policy, please feel free to contact us using the information provided on our Contact Us page.</p>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>
