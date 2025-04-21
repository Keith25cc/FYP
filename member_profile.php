<?php
    session_start();

    if (isset($_SESSION["member_id"])) {
        include("member_header.php");
        include("connect_database.php");

        // Execute the query and handle errors
        $member_id = $_SESSION["member_id"];
        $sql = "SELECT * FROM member_info WHERE member_id = '$member_id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the row of member information
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "<script>
                    alert('Member not found!');
                    history.go(-1);
                  </script>";
        }
    } else {
        echo "<script>
                alert('Please Log In Member Account!');
                history.go(-1);
              </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="manifest" href="manifest.json" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Profile</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Signika&display=swap');

        body, html {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: 'Signika', sans-serif;
        }

        .profile-container {
            width: 600px;
            margin: 100px auto;
            padding: 30px;
            background-color: black;
            border-radius: 15px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid black;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 40px;
            color: white;
        }

        .profile-form-group {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-form-group label {
            font-size: 16px;
            color: white;
        }

        .profile-input {
            width: 330px;
            padding: 10px;
            border: 2px solid black;
            border-radius: 50px;
            background-color: #fff;
            font-size: 14px;
            color: #555;
        }

        .profile-button-container {
            text-align: right;
            margin-top:30px;
        }

        .profile-button {
            padding: 10px 20px;
            border: 2px solid black;
            background-color: white;
            border-radius: 50px;
            font-size: 14px;
            color: #555;
            cursor: pointer;
        }

        .profile-button:hover {
            background-color: #eee;
        }

    </style>
</head>
<body>

    <div class="profile-container">
        <h1>Member Profile</h1>
        
        <div class="profile-form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" class="profile-input" value="<?php echo $row['username']; ?>" readonly>
        </div>
        
        <div class="profile-form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" class="profile-input" value="<?php echo $row['email']; ?>" readonly>
        </div>
        
        <div class="profile-form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" class="profile-input" value="<?php echo $row['phone_number']; ?>" readonly>
        </div>
        
        <div class="profile-form-group">
            <label for="gender">Gender:</label>
            <input type="text" id="gender" class="profile-input" value="<?php echo $row['gender']; ?>" readonly>
        </div>
        
        <div class="profile-form-group">
            <label for="nric">NRIC:</label>
            <input type="text" id="nric" class="profile-input" value="<?php echo $row['nric']; ?>" readonly>
        </div>
        
        <div class="profile-form-group">
            <label for="balance">Account Balance:</label>
            <input type="text" id="balance" class="profile-input" value="<?php echo $row['account_balance']; ?>" readonly>
        </div>

        <div class="profile-button-container">
            <button class="profile-button" onclick="window.location.href='member_edit_profile.php'">Edit Profile</button>
        </div>
    </div>
    <?php
        include("footer.php");
    ?>
    </body>
</html>