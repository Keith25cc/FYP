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
<link rel="manifest" href="manifest.json" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY Trade</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<div id="chart-container">
        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
        <script type="text/javascript">
            new TradingView.widget({
                "container_id": "chart-container",
                "width": "100%",
                "height": "800",
                "symbol": "FX:EURUSD",
                "interval": "D",
                "timezone": "Etc/UTC",
                "theme": "dark",
                "style": "1",
                "locale": "en",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "allow_symbol_change": true,
                "details": true,
                "hotlist": true,
                "calendar": true,
                "news": [
                    "headlines"
                ],
                "hide_side_toolbar": false,
                "studies": [
                    "RSI@tv-basicstudies"
                ],
                "show_popup_button": true,
                "popup_width": "1000",
                "popup_height": "650"
            });
        </script>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>