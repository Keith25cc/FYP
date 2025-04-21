<?php
    if(isset($_SESSION["member_id"])) {
        include("connect_database.php");

        if(isset($_POST["member-logout"])) {
            session_destroy();
            echo
            "<script>
                window.location.href='homepage.php';
            </script>";
        }
    }
    else {
        echo
        "<script>
            alert('Please Log In!');
            window.location.href='member_login.php';
        </script>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <link rel="manifest" href="manifest.json" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Chivo:ital@1&family=Kaushan+Script&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@600&family=Padauk:wght@700&family=Signika&display=swap');

            .header {
                position: fixed;
                top: 0px;
                left: 0px;
                width: 100%;
                height: 80px;
                background-color:#1a1a1a;
                box-shadow: 0px 2px 10px #888888;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 20px;
                z-index: 999;
                position: relative;
            }
            
            body{
                overflow-x:hidden;
            }

            #logo {
                height: 80px;
                width: 80px;
                cursor: pointer; 
            }

            #comp-name {
                border: none;
                height: 60px;
                margin-top: 20px;
                margin-bottom:20px;
                font-size: 50px;
                cursor: pointer;
                font-family: Georgia, serif;
            }
            
            #home-page-icon {
                height: 70px;
                width: 70px;
                cursor: pointer; 
                margin: 4px 0px 0px 0px;
            }

            #menu-button {
                cursor: pointer;
                font-size: 40px;
                margin: 10px 40px 0px 10px;
                font-family: 'Archivo Narrow', sans-serif;
            }

            .comp-name-yellow {
                color: yellow;
            }

            .comp-name-black {
                color: black;
            }

            #profile-icon {
                background-color: white;
                color:white;
                margin: 10px 0px;
                cursor: pointer;
                height: 55px;
                width: 55px;
                border-radius:50%;
                border: 2px solid;
            }

            #member-logout-button {
                cursor: pointer;
                margin: 5px 30px 10px 20px;
                padding: 16px 16px;
                border-radius: 10px;
                font-family: 'Signika', sans-serif;
                font-size: 20px;
                background-color: white;
                color: black;
                border: none;
            }

            #member-logout-button:hover {
                background-color: #545454;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100%;
                background-color: #1a1a1a;
                transition: left 0.3s ease;
                z-index: 999;
                padding-top: 80px;
            }

            .sidebar a {
                display: block;
                padding: 15px;
                text-decoration: none;
                font-size: 20px;
                color: white;
                font-family: 'Signika', sans-serif;
            }

            .sidebar a:hover {
                background-color: white;
                color:black;
            }

            .sidebar-open {
                left: 0;
            }

            .comp-name-yellow {
                color: yellow;
                font-family:"Bodoni MT";
            }

            .comp-name-black {
                color: white;
                font-family:"Bodoni MT";
            }   

            .menu-button {
                height: 40px;
                width: 40px;
                cursor: pointer;
                background: none;
                border: none;
                outline: none;
                padding: 0;
                color:white;
            }

            .menu-button img {
                width: 100%;
                height: 100%;
            }

        </style>  
    <body>
    <div id="sidebar" class="sidebar">
            <a href="member_portfolio.php">My Portfolio</a>
            <a href="member_forum.php">Member Forum</a>
            <a href="chart_view.php">Chart View</a>
            <a href="news.php">News</a>
            <a href="FAQ.php">FAQ</a>
        </div>

        <div class="header">
            <button class="menu-button" onclick="toggleSidebar()">
                <img src="logo_icon/menu.jpg">
            </button>
            <div style="margin: 0px 30px 0px 0px;"></div>

            <img src="logo_icon/mytrade_logo.jpg" onclick="window.location.href='homepage.php'" id="home-page-icon">

            <div style="margin: 0px 400px 0px 0px;"></div>
            <h1 onclick="window.location.href='homepage.php'" id="comp-name">
                <span class="comp-name-yellow">MY</span> 
                <span class="comp-name-black">TRADE</span>
            </h1>
            
            <div style="margin: 0px 0px 0px 380px;"></div>

            <img src="logo_icon/profile.png" onclick="window.location.href='member_profile.php'" id="profile-icon">
            <form action="" method="post">
                <button name="member-logout" id="member-logout-button">Log out</button>
            </form>
        </div>
        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('sidebar-open');
            }
        </script>
    </body>
</html>