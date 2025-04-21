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
    <title>FAQ</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Hind:300,400&display=swap');


        html,body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            margin: 0; 
            padding: 0; 
            height:100%;
            overflow-x: hidden;
            z-index:1;
        }

        * {
            box-sizing: border-box;
        }

        *::before, *::after {
            box-sizing: border-box;
        }

        .container {
            margin: 0 auto;
            padding: 4rem;
            width: 48rem;
        }

        .accordion {
        }
        .accordion .accordion-item {
            border-bottom: 1px solid #e5e5e5;
        }
        .accordion .accordion-item button[aria-expanded='true'] {
            border-bottom: 1px solid #03b5d2;
        }
        .accordion button {
            position: relative;
            display: block;
            text-align: left;
            width: 100%;
            padding: 1em 0;
            color: #7288a2;
            font-size: 1.15rem;
            font-weight: 400;
            border: none;
            background: none;
            outline: none;
        }
        .accordion button:hover,
        .accordion button:focus {
            cursor: pointer;
            color: #03b5d2;
        }
        .accordion button:hover .icon,
        .accordion button:focus .icon {
            cursor: pointer;
            color: #03b5d2;
            border: 1px solid #03b5d2;
        }
        .accordion .accordion-title {
            padding: 1em 1.5em 1em 0;
        }
        .accordion .icon {
            display: inline-block;
            position: absolute;
            top: 18px;
            right: 0;
            width: 22px;
            height: 22px;
            border: 1px solid;
            border-radius: 22px;
        }
        .accordion .icon::before {
            display: block;
            position: absolute;
            content: '';
            top: 9px;
            left: 5px;
            width: 10px;
            height: 2px;
            background: currentColor;
        }
        .accordion .icon::after {
            display: block;
            position: absolute;
            content: '';
            top: 5px;
            left: 9px;
            width: 2px;
            height: 10px;
            background: currentColor;
        }
        .accordion button[aria-expanded='true'] {
            color: #03b5d2;
        }
        .accordion button[aria-expanded='true'] .icon::after {
            width: 0;
        }
        .accordion button[aria-expanded='true'] + .accordion-content {
            opacity: 1;
            max-height: 9em;
            transition: all 200ms linear;
            will-change: opacity, max-height;
        }
        .accordion .accordion-content {
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: opacity 200ms linear, max-height 200ms linear;
            will-change: opacity, max-height;
        }
        .accordion .accordion-content p {
            font-size: 1rem;
            font-weight: 300;
            margin: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Frequently Asked Questions</h2>
            <div class="accordion">
                <div class="accordion-item">
                    <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title">What is the purpose of this platform?</span><span class="icon" aria-hidden="true"></span></button>
                    <div class="accordion-content">
                        <p>This platform is designed to help users create and manage portfolios while tracking forex charts. It allows users to monitor their investments and set goals for currency pairings without executing trades.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <button id="accordion-button-2" aria-expanded="false"><span class="accordion-title">Can I trade directly through this platform?</span><span class="icon" aria-hidden="true"></span></button>
                    <div class="accordion-content">
                        <p>No, this platform does not support trading. It is a portfolio management tool where users can create and track their investments using live forex charts.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <button id="accordion-button-3" aria-expanded="false"><span class="accordion-title">How do I add a new currency pairing to my portfolio?</span><span class="icon" aria-hidden="true"></span></button>
                    <div class="accordion-content">
                        <p>To add a new currency pairing, go to the 'Add Portfolio' section, select the currency pair, set your target price, and define your lot size. You can track the performance of these pairings over time.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <button id="accordion-button-4" aria-expanded="false"><span class="accordion-title">How often are the charts updated?</span><span class="icon" aria-hidden="true"></span></button>
                    <div class="accordion-content">
                        <p>The charts are updated with live data, ensuring that users can track the most current forex prices for the currencies in their portfolios.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <button id="accordion-button-5" aria-expanded="false"><span class="accordion-title">Can I customize my portfolio goals?</span><span class="icon" aria-hidden="true"></span></button>
                    <div class="accordion-content">
                        <p>Yes, users can set specific profit goals for each currency pairing in their portfolio, and the system will calculate the progress based on real-time data.</p>
                    </div>
                </div>
            </div>
    </div>
    <?php include("footer.php"); ?>
    <script>
        const items = document.querySelectorAll(".accordion button");

        function toggleAccordion() {
        const itemToggle = this.getAttribute('aria-expanded');
        
        for (i = 0; i < items.length; i++) {
            items[i].setAttribute('aria-expanded', 'false');
        }
        
        if (itemToggle == 'false') {
            this.setAttribute('aria-expanded', 'true');
        }
        }

        items.forEach(item => item.addEventListener('click', toggleAccordion));
    </script>
</body>
</html>