<?php
session_start();

if (!isset($_SESSION["member_id"])) {
    echo "<script>
        alert('Please log in to access this page.');
        window.location.href='login.php';
    </script>";
    exit();
}

include("connect_database.php");

if (isset($_GET['id'])) {
    $forum_id = $_GET['id'];
    $member_id = $_SESSION['member_id'];

    // Get the current forum data
    $sql = "SELECT * FROM forum_discuss WHERE forum_id = '$forum_id' AND member_id = '$member_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $forum_data = $result->fetch_assoc();
    } else {
        echo "<script>
            alert('Forum post not found or does not belong to you.');
            window.location.href='member_view_own_forum.php';
        </script>";
        exit();
    }

    // Handle form submission for editing the forum post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pairing = $_POST['pairing'];
        $forum_content = $_POST['forum_content'];
        $forum_pic = $forum_data['forum_pic'];

        // Handle file upload if a new picture is uploaded
        if (!empty($_FILES['forum_pic']['name'])) {
            $target_dir = "member_forum_pic/";
            $target_file = $target_dir . basename($_FILES['forum_pic']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file size
            if ($_FILES['forum_pic']['size'] > 500000) {
                echo "<script>alert('Sorry, your file is too large.');</script>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                echo "<script>
                    alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                    history.go(-1);
                </script>";
                exit();
            }

            // Check if $uploadOk is set to 0 by an error
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
            }
        }

        // Update the forum post in the database
        $update_sql = "UPDATE forum_discuss SET pairing = '$pairing', forum_content = '$forum_content', forum_pic = '$forum_pic' WHERE forum_id = '$forum_id' AND member_id = '$member_id'";
        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Forum post updated successfully!'); window.location.href='member_view_own_forum.php';</script>";
        } else {
            echo "<script>alert('Error: ' . $update_sql . ' ' . $conn->error);</script>";
        }
    }
} else {
    echo "<script>
        alert('No forum ID provided.');
        window.location.href='member_view_own_forum.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Forum Post</title>
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
            margin-top:40px;
            margin-bottom:40px;
            font-size:40px;
        }

        .edit-forum-form {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .edit-forum-form input[type="text"],
        .edit-forum-form textarea {
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .edit-forum-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .edit-forum-form input[type="file"] {
            margin-bottom: 10px;
        }

        .edit-forum-form input[type="submit"] {
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
    <h1>Edit Forum Post</h1>
    <div class="edit-forum-form">
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="pairing">Pairing:</label>
            <select name="pairing" id="pairing" required>
                <option value="AUDUSD" <?php if ($forum_data['pairing'] == 'AUDUSD') echo 'selected'; ?>>AUDUSD</option>
                <option value="AUDJPY" <?php if ($forum_data['pairing'] == 'AUDJPY') echo 'selected'; ?>>AUDJPY</option>
                <option value="AUDNZD" <?php if ($forum_data['pairing'] == 'AUDNZD') echo 'selected'; ?>>AUDNZD</option>
                <option value="AUDCAD" <?php if ($forum_data['pairing'] == 'AUDCAD') echo 'selected'; ?>>AUDCAD</option>
                <option value="AUDCHF" <?php if ($forum_data['pairing'] == 'AUDCHF') echo 'selected'; ?>>AUDCHF</option>
                <option value="CADJPY" <?php if ($forum_data['pairing'] == 'CADJPY') echo 'selected'; ?>>CADJPY</option>
                <option value="CADCHF" <?php if ($forum_data['pairing'] == 'CADCHF') echo 'selected'; ?>>CADCHF</option>
                <option value="CHFJPY" <?php if ($forum_data['pairing'] == 'CHFJPY') echo 'selected'; ?>>CHFJPY</option>
                <option value="EURNOK" <?php if ($forum_data['pairing'] == 'EURNOK') echo 'selected'; ?>>EURNOK</option>
                <option value="EURUSD" <?php if ($forum_data['pairing'] == 'EURUSD') echo 'selected'; ?>>EURUSD</option>
                <option value="EURCHF" <?php if ($forum_data['pairing'] == 'EURCHF') echo 'selected'; ?>>EURCHF</option>
                <option value="EURTRY" <?php if ($forum_data['pairing'] == 'EURTRY') echo 'selected'; ?>>EURTRY</option>
                <option value="EURGBP" <?php if ($forum_data['pairing'] == 'EURGBP') echo 'selected'; ?>>EURGBP</option>
                <option value="EURJPY" <?php if ($forum_data['pairing'] == 'EURJPY') echo 'selected'; ?>>EURJPY</option>
                <option value="EURAUD" <?php if ($forum_data['pairing'] == 'EURAUD') echo 'selected'; ?>>EURAUD</option>
                <option value="EURCAD" <?php if ($forum_data['pairing'] == 'EURCAD') echo 'selected'; ?>>EURCAD</option>
                <option value="EURNZD" <?php if ($forum_data['pairing'] == 'EURNZD') echo 'selected'; ?>>EURNZD</option>
                <option value="EURSEK" <?php if ($forum_data['pairing'] == 'EURSEK') echo 'selected'; ?>>EURSEK</option>
                <option value="GBPJPY" <?php if ($forum_data['pairing'] == 'GBPJPY') echo 'selected'; ?>>GBPJPY</option>
                <option value="GBPNZD" <?php if ($forum_data['pairing'] == 'GBPNZD') echo 'selected'; ?>>GBPNZD</option>
                <option value="GBPAUD" <?php if ($forum_data['pairing'] == 'GBPAUD') echo 'selected'; ?>>GBPAUD</option>
                <option value="GBPCHF" <?php if ($forum_data['pairing'] == 'GBPCHF') echo 'selected'; ?>>GBPCHF</option>
                <option value="GBPUSD" <?php if ($forum_data['pairing'] == 'GBPUSD') echo 'selected'; ?>>GBPUSD</option>
                <option value="GBPCAD" <?php if ($forum_data['pairing'] == 'GBPCAD') echo 'selected'; ?>>GBPCAD</option>
                <option value="NZDCHF" <?php if ($forum_data['pairing'] == 'NZDCHF') echo 'selected'; ?>>NZDCHF</option>
                <option value="NZDJPY" <?php if ($forum_data['pairing'] == 'NZDJPY') echo 'selected'; ?>>NZDJPY</option>
                <option value="NZDUSD" <?php if ($forum_data['pairing'] == 'NZDUSD') echo 'selected'; ?>>NZDUSD</option>
                <option value="NZDCAD" <?php if ($forum_data['pairing'] == 'NZDCAD') echo 'selected'; ?>>NZDCAD</option>
                <option value="TRYJPY" <?php if ($forum_data['pairing'] == 'TRYJPY') echo 'selected'; ?>>TRYJPY</option>
                <option value="USDHKD" <?php if ($forum_data['pairing'] == 'USDHKD') echo 'selected'; ?>>USDHKD</option>
                <option value="USDNOK" <?php if ($forum_data['pairing'] == 'USDNOK') echo 'selected'; ?>>USDNOK</option>
                <option value="USDSEK" <?php if ($forum_data['pairing'] == 'USDSEK') echo 'selected'; ?>>USDSEK</option>
                <option value="USDZAR" <?php if ($forum_data['pairing'] == 'USDZAR') echo 'selected'; ?>>USDZAR</option>
                <option value="USDMXN" <?php if ($forum_data['pairing'] == 'USDMXN') echo 'selected'; ?>>USDMXN</option>
                <option value="USDTRY" <?php if ($forum_data['pairing'] == 'USDTRY') echo 'selected'; ?>>USDTRY</option>
                <option value="USDCAD" <?php if ($forum_data['pairing'] == 'USDCAD') echo 'selected'; ?>>USDCAD</option>
                <option value="USDCHF" <?php if ($forum_data['pairing'] == 'USDCHF') echo 'selected'; ?>>USDCHF</option>
                <option value="USDJPY" <?php if ($forum_data['pairing'] == 'USDJPY') echo 'selected'; ?>>USDJPY</option>
                <option value="USDCNH" <?php if ($forum_data['pairing'] == 'USDCNH') echo 'selected'; ?>>USDCNH</option>
                <option value="ZARJPY" <?php if ($forum_data['pairing'] == 'ZARJPY') echo 'selected'; ?>>ZARJPY</option>
            </select>
            <br><br>
            <label for="forum_content">Content:</label>
            <textarea name="forum_content" id="forum_content" rows="5" required><?php echo $forum_data['forum_content']; ?></textarea><br>
            <label for="forum_pic">Upload Picture (Optional, Max 500MB):</label>
            <input type="file" name="forum_pic" id="forum_pic"><br>
            <?php if (!empty($forum_data['forum_pic'])) { ?>
                <p>Current Picture:</p>
                <div class="forum-picture">
                    <img src="member_forum_pic/<?php echo $forum_data['forum_pic']; ?>" alt="Current Forum Picture">
                </div>
            <?php } ?>
            <input type="submit" value="Update Forum">
        </form>
    </div>
    <?php
        include("footer.php");
    ?>
</body>
</html>

