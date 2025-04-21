<?php
session_start();

include("member_header.php");

include("connect_database.php");
$member_id = $_SESSION["member_id"];
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
            'date_of_post' => $row['date_of_post'],
            'forum_content' => $row['forum_content'],
            'forum_pic' => $row['forum_pic']
        ];
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
            margin-top:40px;
            margin-bottom:40px;
            font-size:40px;
        }

        .forum-container {
            width: 80%;
            margin: 20px auto;
        }

        .forum-details {
            background-color: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-wrap: break-word;
        }

        .forum-details p {
            font-size: 16px;
            line-height: 1.6;
            word-wrap: break-word;
        }

        .forum-details strong {
            color: #555;
        }

        .forum-content {
            margin-top: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
            border-radius: 4px;
            word-wrap: break-word;
        }

        .forum-picture {
            margin-top: 20px;
            text-align: center;
        }

        .forum-picture img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            padding: 8px 15px;
            font-size: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-add {
            background-color: #FF5733;
            margin:10px 5px auto 155px; 
        }

        .btn-add:hover {
            background-color: #C4451C;
            transform: scale(1.05);  
        }
    </style>
</head>
<body>
    <div>
        <h1>Forum Discussions</h1>
        <button class='btn btn-add' onclick= "window.location.href='member_add_new_forum.php'">Add New Forum</button>
        <br>
        <button class='btn btn-add' onclick= "window.location.href='member_view_own_forum.php'" style="margin-top:25px;">View Own Forum</button>
    </div>
    <div class="forum-container">
        <?php
        if (!empty($forum_data)) {
            foreach ($forum_data as $forum) {
        ?>
        <div class="forum-details">
            <p><strong>Member:</strong> <?php echo $forum['member_username']; ?></p>
            <p><strong>Pairing:</strong> <?php echo $forum['pairing']; ?></p>
            <p><strong>Date of post:</strong> <?php echo $forum['date_of_post']; ?></p>
            <div class="forum-content">
                <p><?php echo nl2br($forum['forum_content']); ?></p>
            </div>
            <?php if (!empty($forum['forum_pic'])) { ?>
                <div class="forum-picture">
                    <img src="member_forum_pic/<?php echo $forum['forum_pic']; ?>" alt="Forum Picture">
                </div>
            <?php } ?>
        </div>
        <?php
            }
        } else {
            echo "<p>No forum discussions available.</p>";
        }
        ?>
    </div>
    <?php
        include("footer.php")
    ?>
</body>
</html>


