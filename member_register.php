<?php
    session_start();
    
    if((!isset($_SESSION["member_id"])) and (!isset($_SESSION["admin_id"]))) {
        include("before_login_header.php");
    }
    else {
        echo
        "<script>
            alert('Please Log Out The Current Accout Before Accessing Ths Page!');
            window.location.href='homepage.php';
        </script>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <link rel="manifest" href="manifest.json" />
        <title>Member Register</title>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@600&family=Padauk:wght@700&family=Signika&display=swap');
            
            html,body { 
                font-family: Arial, sans-serif; 
                background-color: #f4f4f4; 
                margin: 0; 
                padding: 0; 
                height:100%;
                overflow-x: hidden;
                z-index:1;
            }

            .form-container {
                margin: 100px auto;
                background-color: white;
                width: 700px;
                padding: 15px;
                border: black;
                display: flex;
                flex-wrap: wrap;
                box-shadow: 0 10px 15px rgba(0,0,0,.1);
            }

            .form-title {
                margin: 30px auto 40px;
                text-align: center;
                font-size: 40px;
                font-family: 'Archivo Narrow', sans-serif;
            }

            .form-box1 {
                margin: 0px 10px 0px 40px;
                width: 300px;
                font-family: 'Padauk', sans-serif;
                font-size: 18px;
            }

            .form-box2 {
                margin: 0px 30px 0px 10px;
                width: 300px;
                font-family: 'Padauk', sans-serif;
                font-size: 18px;
            }

            input[type=text], input[type=tel], input[type=email], input[type=password],input[type=number] {
                background-color: #ededed;
                border-color: #d4d4d4;
                color: black;
                width: 292px;
                height: 40px;
                border: 2px solid #ccc;
                border-radius: 8px;
                font-family: 'Signika', sans-serif;
                font-size: 18px;
            }

            select {
                background-color: #ededed;
                border-color: #d4d4d4;
                color: black;
                width: 300px;
                height: 46px;
                border: 2px solid #ccc;
                border-radius: 8px;
                font-family: 'Signika', sans-serif;
                font-size: 18px;
            }

            input[type=submit] {
                background-color: black;
                color: white;
                margin: 20px auto 20px;
                border: none;
                border-radius: 10px;
                padding: 16px 50px;
                cursor: pointer;
                font-size: 20px;
                font-family: 'Signika', sans-serif;
            }

            input[type=submit]:hover {
                background-color: yellow;
                color:black;
            }
        </style>

        <script>
            function validate_form() {
                var confirm_password = document.getElementById("conpass").value;
                var password = document.getElementById("pass").value;

                if (confirm_password != password) {
                    alert("Confirm Password And Password Must Be Same.");
                    return false;
                }
                else if (password.length < 8) {
                    alert("Please Enter At Least 8 Characters For Your Password.");
                    return false;
                }
                else {
                    return true;
                }
            }
        </script>
    </head>

    <body>
        <form action="insert_data_member_register.php" method="post" enctype="multipart/form-data" onsubmit="return validate_form()">
            <div class="form-container">
                <div class="form-title">
                    <strong>Member Account Registration</strong>
                </div>

                <div class="form-box1">
                    <strong>FIRST NAME</strong><br>
                    <input type="text" name="register_member_first_name" placeholder="First Name" required="required">
                </div>

                <div class="form-box1">
                    <strong>LAST NAME</strong><br>
                    <input type="text" name="register_member_last_name" placeholder="Last Name" required="required">
                </div>

                <div class="form-box1"> 
                    <strong>GENDER</strong><br>
                    <select name="register_member_gender" required="required">
                        <option value="">Please Select Your Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select><br><br>
                </div>

                <div class="form-box1">
                    <strong>EMAIL</strong><br>
                    <input type="email" name="register_member_email" placeholder="Email" required="required"><br><br>
                </div>

                <div class="form-box1">
                    <strong>NRIC</strong><br>
                    <input type="number" name="register_member_nric" placeholder="NRIC" required="required"><br><br>
                </div>

                <div class="form-box1">
                    <strong>USERNAME</strong><br>
                    <input type="text" name="register_member_username" placeholder="Username" required="required"><br><br>
                </div>

                <div class="form-box1">
                    <strong>PHONE NUMBER</strong><br>
                    <input type="tel" name="register_member_phone_number" pattern="[0-9]{3}-[0-9]{7}|[0-9]{3}-[0-9]{8}" placeholder="012-3456789 / 012-34567890" required="required"><br><br>
                </div>

                <div class="form-box1">
                    <strong>ACCOUNT BALANCE</strong><br>
                    <input type="number" name="register_member_account_balance" placeholder="Account Balance" required="required"><br><br>
                </div>

                <div class="form-box1">
                    <strong>PASSWORD</strong><br>
                    <input type="password" id="pass" name="register_member_password" placeholder="Password" required="required"><br><br>
                </div>

                <div class="form-box1">
                    <strong>CONFIRM PASSWORD</strong><br>
                    <input type="password" id="conpass" name="register_member_confirm_password" placeholder="Confirm Password" required="required"><br><br>
                </div>

                <input type="submit" value="Register">
            </div>
        </form>

        <?php
            include("footer.php");
        ?>
    </body>
</html>