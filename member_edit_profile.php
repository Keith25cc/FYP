<?php
session_start();
include("connect_database.php");  // Ensure the database connection is correct
include("member_header.php");

$member_id = $_SESSION['member_id'];

// Fetch the current user data
$query = "SELECT * FROM member_info WHERE member_id = '$member_id'";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nric = mysqli_real_escape_string($conn, $_POST['nric']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $account_balance = mysqli_real_escape_string($conn, $_POST['account_balance']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Initialize error messages
    $errors = [];

    // Check if the email, NRIC, username, or phone number is already in use (excluding current user)
    $check_query = "SELECT * FROM member_info WHERE (email = '$email' OR nric = '$nric' OR username = '$username' OR phone_number = '$phone_number') AND member_id != '$member_id'";
    $check_result = mysqli_query($conn, $check_query);

    while ($row = mysqli_fetch_assoc($check_result)) {
        if ($row['email'] === $email) {
            $errors['email'] = "Email is already in use.";
        }
        if ($row['nric'] === $nric) {
            $errors['nric'] = "NRIC is already in use.";
        }
        if ($row['username'] === $username) {
            $errors['username'] = "Username is already in use.";
        }
        if ($row['phone_number'] === $phone_number) {
            $errors['phone_number'] = "Phone number is already in use.";
        }
    }

    // Additional validation for NRIC and password
    if (!preg_match('/^\d{12}$/', $nric)) {
        $errors['nric'] = "NRIC must be exactly 12 digits.";
    }
    if (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters.";
    }

    // If no errors, update the profile
    if (empty($errors)) {
        $update_query = "
            UPDATE member_info 
            SET 
                first_name = '$first_name', 
                last_name = '$last_name', 
                gender = '$gender', 
                email = '$email', 
                nric = '$nric', 
                username = '$username', 
                phone_number = '$phone_number',
                account_balance = '$account_balance', 
                password = '$password' 
            WHERE member_id = '$member_id'";
        
        if (mysqli_query($conn, $update_query)) {
            $success_message = "Profile updated successfully!";
        } else {
            $error_message = "Error updating profile: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 100px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input, select {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        input[type="submit"] {
            background-color: black;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: yellow;
            color:black;
        }

        .error-message {
            color: red;
            margin-bottom: 20px;
            text-align: center;
        }

        .success-message {
            color: green;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>

        <!-- Show success or error messages -->
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?= $success_message ?></div>
            <script>
                    alert("Member Profile Updated Successfully!");
                    window.location.href = "member_profile.php";
            </script>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Form to edit profile -->
        <form method="POST" action="member_edit_profile.php">
            <!-- First Name -->
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?= $user_data['first_name'] ?>" required>

            <!-- Last Name -->
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?= $user_data['last_name'] ?>" required>

            <!-- Gender -->
            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="Male" <?= $user_data['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $user_data['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>

            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $user_data['email'] ?>" required>

            <!-- NRIC -->
            <label for="nric">NRIC</label>
            <input type="text" name="nric" id="nric" value="<?= $user_data['nric'] ?>" pattern="\d{12}" title="NRIC must be 12 digits." required>

            <!-- Username -->
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= $user_data['username'] ?>" required>

            <!-- Phone Number -->
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" value="<?= $user_data['phone_number'] ?>" required>

            <!-- Account Balance -->
            <label for="account_balance">Account Balance</label>
            <input type="number" name="account_balance" id="account_balance" step="0.01" value="<?= $user_data['account_balance'] ?>" required>

            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?= $user_data['password'] ?>" minlength="8" required>

            <!-- Submit Button -->
            <input type="submit" value="Update Profile">
        </form>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
