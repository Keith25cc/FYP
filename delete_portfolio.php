<?php
session_start();
include("connect_database.php");

if (isset($_GET['id'])) {
    $portfolio_id = $_GET['id'];
    $member_id = $_SESSION['member_id'];

    $query = "DELETE FROM member_portfolio WHERE portfolio_id = ? AND member_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $portfolio_id, $member_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Portfolio deleted successfully.');
                window.location.href = 'member_portfolio.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to delete portfolio.');
                window.location.href = 'member_portfolio.php';
              </script>";
    }
} else {
    header("Location: member_portfolio.php");
    exit();
}
?>
