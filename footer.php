<!DOCTYPE html>
<html>
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Neuton:ital@1&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Mada:wght@500&display=swap');

            .footer {
                display: flex;
                flex-direction: column;
                background-color: #1a1a1a;
                color: #f0f0f0;
                padding: 40px 20px;
                width: 100%;
                box-shadow: 0px -3px 20px #888888;
                margin-top: 40px;
                font-family: "Bodoni MT";
            }

            .footer-box {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }

            .logo-container {
                display: flex;
                align-items: center;
            }

            .logo-container img {
                height: 80px;
                width: 80px;
                cursor: pointer;
                margin-right: 20px;
            }

            .footer-links {
                display: flex;
                justify-content: center;
                gap: 30px;
                margin-top: 20px;
            }

            .footer-links p {
                font-size: 16px;
                margin: 0;
                cursor: pointer;
                transition: color 0.3s;
            }

            .footer-links p:hover {
                color: #ff7b00;
            }

            .footer-bottom {
                text-align: center;
                font-family: "Bodoni MT";
                font-weight: bold;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="footer">
            <div class="footer-box">
                <div class="logo-container">
                    <img src="logo_icon/mytrade_logo.jpg" onclick="window.location.href='homepage.php'" id="logo">
                    <h1 onclick="window.location.href='homepage.php'" id="comp-name">
                        <span class="comp-name-yellow">MY</span> 
                        <span class="comp-name-black">TRADE</span>
                    </h1>
                </div>
                <div class="footer-links">
                    <p onclick="location.href='FAQ.php'">FAQ</p>
                    <p onclick="location.href='about_us.php'">About Us</p>
                    <p onclick="location.href='contact_us.php'">Contact Us</p>
                    <p onclick="location.href='privacy_policy.php'">Privacy Policy</p>
                </div>
            </div>
            <div class="footer-bottom">
                Copyright @ 2024 By CHAN YI CHOON
            </div>
        </div>
    </body>
</html>