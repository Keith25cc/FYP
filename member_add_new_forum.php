<?php
session_start();

if (isset($_SESSION["member_id"])) {
    include("member_header.php");
} else {
    include("before_login_header.php");
}

include("connect_database.php");
// Query to get all forum discussions
$sql = "SELECT * FROM forum_discuss";
$result = $conn->query($sql);

$forum_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $member_id = $row['member_id'];

        // Get member information
        $member_sql = "SELECT username FROM member_info WHERE member_id = '$member_id'";
        $member_result = $conn->query($member_sql);
        $member_username = "Unknown Username";
        if ($member_result->num_rows > 0) {
            $member_row = $member_result->fetch_assoc();
            $member_username = $member_row['username'];
        }

        // Forum details
        $forum_data[] = [
            'member_username' => $member_username,
            'pairing' => $row['pairing'],
            'forum_content' => $row['forum_content'],
            'forum_pic' => $row['forum_pic'],
            'date_of_post' => $row['date_of_post']
        ];
    }
}

// Handle form submission for adding new forum post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the session variable `member_id` is set
    if (!isset($_SESSION["member_id"])) {
        echo "<script>alert('Please log in to add a forum post.'); window.location.href='login_page.php';</script>";
        exit();
    }

    $member_id = $_SESSION["member_id"]; // Retrieve member_id from session
    $pairing = $_POST['pairing'];
    $forum_content = $_POST['forum_content'];
    $forum_pic = "";

    // Handle file upload
    $uploadOk = 1;
    if (!empty($_FILES['forum_pic']['name'])) {
        $target_dir = "member_forum_pic/";
        $target_file = $target_dir . basename($_FILES['forum_pic']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size
        if ($_FILES['forum_pic']['size'] > 500000) {
            echo "<script>alert('Sorry, your file is too large.'); history.go(-1);</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "<script>
                    alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                    history.go(-1);
                  </script>";
            $uploadOk = 0;
        }

        // Attempt to move the uploaded file if validation passes
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES['forum_pic']['tmp_name'], $target_file)) {
                $forum_pic = basename($_FILES['forum_pic']['name']);
            } else {
                echo "<script>
                        alert('Sorry, there was an error uploading your file.');
                        history.go(-1);
                      </script>";
                exit();
            }
        } else {
            exit(); // Stop execution if upload failed
        }
    }

    // Insert new forum post into the database if no file upload errors occurred
    if ($uploadOk == 1) {
        $insert_sql = "INSERT INTO forum_discuss (member_id, pairing, forum_content, forum_pic, date_of_post) 
                       VALUES ('$member_id', '$pairing', '$forum_content', '$forum_pic', NOW())";
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('New forum post added successfully!'); window.location.href='member_forum.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .add-forum-form {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .add-forum-form input[type="text"],
        .add-forum-form textarea { width: 95%; height:200px; }
        .add-forum-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .add-forum-form input[type="file"] {
            margin-bottom: 10px;
        }

        .add-forum-form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Forum Discussions</h1>
    <div class="add-forum-form">
        <h2>Add New Forum Post</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="pairing">Pairing:</label>
            <select name="pairing" id="pairing" required style="width:120px;">
                <option value="AUDUSD">AUDUSD</option>
                <option value="AUDJPY">AUDJPY</option>
                <option value="AUDNZD">AUDNZD</option>
                <option value="AUDCAD">AUDCAD</option>
                <option value="AUDCHF">AUDCHF</option>
                <option value="CADJPY">CADJPY</option>
                <option value="CADCHF">CADCHF</option>
                <option value="CHFJPY">CHFJPY</option>
                <option value="EURNOK">EURNOK</option>
                <option value="EURUSD">EURUSD</option>
                <option value="EURCHF">EURCHF</option>
                <option value="EURTRY">EURTRY</option>
                <option value="EURGBP">EURGBP</option>
                <option value="EURJPY">EURJPY</option>
                <option value="EURAUD">EURAUD</option>
                <option value="EURCAD">EURCAD</option>
                <option value="EURNZD">EURNZD</option>
                <option value="EURSEK">EURSEK</option>
                <option value="GBPJPY">GBPJPY</option>
                <option value="GBPNZD">GBPNZD</option>
                <option value="GBPAUD">GBPAUD</option>
                <option value="GBPCHF">GBPCHF</option>
                <option value="GBPUSD">GBPUSD</option>
                <option value="GBPCAD">GBPCAD</option>
                <option value="NZDCHF">NZDCHF</option>
                <option value="NZDJPY">NZDJPY</option>
                <option value="NZDUSD">NZDUSD</option>
                <option value="NZDCAD">NZDCAD</option>
                <option value="TRYJPY">TRYJPY</option>
                <option value="USDHKD">USDHKD</option>
                <option value="USDNOK">USDNOK</option>
                <option value="USDSEK">USDSEK</option>
                <option value="USDZAR">USDZAR</option>
                <option value="USDMXN">USDMXN</option>
                <option value="USDTRY">USDTRY</option>
                <option value="USDCAD">USDCAD</option>
                <option value="USDCHF">USDCHF</option>
                <option value="USDJPY">USDJPY</option>
                <option value="USDCNH">USDCNH</option>
                <option value="ZARJPY">ZARJPY</option>
            </select>
            <br>
            <br>
            <label for="forum_content">Content:</label>
            <br>
            <br>
            <textarea name="forum_content" id="forum_content" rows="5" required></textarea><br>
            <label for="forum_pic">Upload Picture (Optional, Max 500MB):</label>
            <br>
            <br>
            <input type="file" name="forum_pic" id="forum_pic"><br>
            <input type="submit" value="Add Forum" style="margin-top:30px; font-size:20px; margin-left:530px;">
        </form>
    </div>
    <?php
        include("footer.php")
    ?>
</body>
</html>
