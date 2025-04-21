<?php
session_start();
include("connect_database.php");

$pairing = $_GET['pairing'];
$query = "SELECT * FROM member_portfolio WHERE currency_pairing = '$pairing'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goal_price = $_POST['goal_price'];
    $lot_size = $_POST['lot_size'];

    // Update the portfolio in the database
    $update_query = "UPDATE member_portfolio 
                     SET profit_goal = '$goal_price', lot_size = '$lot_size' 
                     WHERE currency_pairing = '$pairing'";
    mysqli_query($conn, $update_query);

    // After saving, redirect to member_portfolio.php with a success message
    echo "<script>
        alert('Changes have been made successfully!');
        window.location.href = 'member_portfolio.php';
    </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .edit-container {
            width: 400px;
            background-color: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-save {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>Edit Portfolio: <?php echo htmlspecialchars($pairing); ?></h2>
    <form method="post">
        <div class="form-group">
            <label for="goal_price" class="form-label">Goal Price</label>
            <input type="number" step="0.0001" class="form-control" id="goal_price" name="goal_price" 
                   value="<?php echo htmlspecialchars($data['profit_goal']); ?>" required>
        </div>

        <div class="form-group">
            <label for="lot_size" class="form-label">Lot Size</label>
            <input type="number" step="0.01" class="form-control" id="lot_size" name="lot_size" 
                   value="<?php echo htmlspecialchars($data['lot_size']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary btn-save">Save Changes</button>
        <a href="member_portfolio.php" class="back-link">Back to Portfolio</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
