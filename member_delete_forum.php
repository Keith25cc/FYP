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

    // Check if the forum belongs to the logged-in member
    $sql = "SELECT * FROM forum_discuss WHERE forum_id = '$forum_id' AND member_id = '$member_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Delete the forum post
        $delete_sql = "DELETE FROM forum_discuss WHERE forum_id = '$forum_id'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "<script>
                alert('Forum post deleted successfully.');
                window.location.href='member_view_own_forum.php';
            </script>";
        } else {
            echo "<script>
                alert('Error deleting forum post: ' . $conn->error);
                window.location.href='member_view_own_forum.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Forum post not found or does not belong to you.');
            window.location.href='member_view_own_forum.php';
        </script>";
    }
} else {
    echo "<script>
        alert('No forum ID provided.');
        window.location.href='member_view_own_forum.php';
    </script>";
}

$conn->close();
?>
