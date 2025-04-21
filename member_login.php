<?php
    session_start();
    
    if((!isset($_SESSION["member_id"]))) {
        include("before_login_header.php");

        if(isset($_POST["login"])) {
            include("connect_database.php");
            $sql = "SELECT *
            FROM member_info
            WHERE username = '".$_POST['log_in_member_username']."' AND password = '".$_POST['log_in_member_password']."' ";
            
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
    
            if($row) {
                $_SESSION["member_id"] = $row["member_id"];
                echo
                "<script>
                    window.location.href='homepage_after_login.php';
                </script>";
            } 
            else {
                echo
                "<script>
                    alert('Your Username or Password is Wrong! Please Try Again!');
                    history.go(-1);
                </script>";
            }
            
            mysqli_close($conn);
        }
    }
    else {
        echo
        "<script>
            alert('Please Log Out The Current Account Before Accessing This Page!');
            window.location.href='homepage.php';
        </script>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <link rel="manifest" href="manifest.json" />
        <title>Member Log In</title>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@600&family=Padauk:wght@700&family=Signika&display=swap');

            html,body { 
                font-family:"Bodoni MT";
                background-color: #f4f4f4; 
                margin: 0; 
                padding: 0; 
                height:100%;
                overflow-x: hidden;
            }

            .login-container {
                margin: 80px auto;
                background-color: black;
                width: 1200px;
                padding: 15px 15px 40px 15px;
                border-style:solid;
                display: flex;
                flex-wrap: wrap;
                box-shadow: 0 10px 15px rgba(0,0,0,.1);
            }

            .login-form {
                flex: 1;
                padding: 50px;
                background-color: black;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: flex-start;
            }

            .login-form h1 {
                font-family: 'Archivo Narrow', sans-serif;
                font-size: 40px;
                margin-bottom: 10px;
                color: white;
            }

            .login-form p {
                margin-bottom: 20px;
                font-size: 18px;
                color: #777;
            }

            .login-form input[type="text"], .login-form input[type="password"] {
                width: 500px;
                padding: 10px;
                margin-top:15px;
                margin-bottom: 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
                font-size: 16px;
            }

            .login-form input[type="submit"] {
                background-color: #007bff;
                color: white;
                padding: 15px 0;
                border: none;
                border-radius: 8px;
                width: 150px;
                font-size: 18px;
                cursor: pointer;
            }

            .login-form input[type="submit"]:hover {
                background-color: #0056b3;
            }

            .comp-name-yellow {
                color: yellow;
                font-family:"Bodoni MT";
            }

            .comp-name-black {
                color: white;
                font-family:"Bodoni MT";
            }

            .image {
                margin-top:30px;
                width:10px;
                height:5px;
            }

            .image-container {
                flex: 1;
                width:10px;
                height:500px;
            }
        </style>
    </head>

    <body>
        <div class="login-container">
            <div class="login-form">
                <h1>Welcome Back Trader</h1>

                <form action="" method="post">
                    <label style="color:white">Username</label>
                    <br>
                    <input type="text" name="log_in_member_username" placeholder="Username" required="required">

                    <label style="color:white">Password</label>
                    <br>
                    <input type="password" name="log_in_member_password" placeholder="Password" required="required">

                    <input type="submit" name="login" value="LOGIN">
                </form>
            </div>
            <div class="image-container">
                <div class="image">
                    <img src="logo_icon/mytrade_logo_blue.jpg">
                </div>
            </div>
        </div>

        <?php include("footer.php"); ?>
    </body>
</html>
