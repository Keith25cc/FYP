<?php
session_start();
include("connect_database.php");  // Ensure the database connection is correct
include("member_header.php");

// Define the list of possible Forex pairings
$forex_pairs = 
["AUDUSD", "AUDJPY", "AUDNZD", 
 "AUDCAD", "AUDCHF", "CADJPY", 
 "CADCHF", "CHFJPY", "EURNOK", 
 "EURUSD", "EURCHF", "EURTRY", 
 "EURGBP", "EURJPY", "EURAUD", 
 "EURCAD", "EURNZD", "EURSEK", 
 "GBPJPY", "GBPNZD", "GBPAUD", 
 "GBPCHF", "GBPUSD", "GBPCAD", 
 "NZDCHF", "NZDJPY", "NZDUSD", 
 "NZDCAD", "TRYJPY", "USDHKD", 
 "USDNOK", "USDSEK", "USDZAR", 
 "USDMXN", "USDTRY", "USDCAD", 
 "USDCHF", "USDJPY", "USDCNH", 
 "ZARJPY"];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_SESSION['member_id']; // Get member ID from the session
    $currency_pairing = mysqli_real_escape_string($conn, $_POST['currency_pairing']);
    $profit_goal = mysqli_real_escape_string($conn, $_POST['profit_goal']);
    $lot_size = mysqli_real_escape_string($conn, $_POST['lot_size']);
    $date_of_entry = mysqli_real_escape_string($conn, $_POST['date_of_entry']);
    
    // Ensure the date of entry is not later than today's date
    if ($date_of_entry > date('Y-m-d')) {
        $error_message = "Date of entry cannot be later than today's date.";
    } elseif ($lot_size <= 0.01) {
        $error_message = "Lot size must be greater than 0.01.";
    } elseif (!preg_match("/^\d+(\.\d{3})$/", $profit_goal)) {
        $error_message = "Profit goal must be a number with exactly 3 decimal places (e.g., 10.000).";
    } else {
        // Insert the new portfolio into the database
        $query = "INSERT INTO member_portfolio (member_id, currency_pairing, profit_goal, lot_size, date_of_entry) 
                  VALUES ('$member_id', '$currency_pairing', '$profit_goal', '$lot_size', '$date_of_entry')";
        if (mysqli_query($conn, $query)) {
            $success_message = "New portfolio added successfully!";
        } else {
            $error_message = "Error adding portfolio: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Portfolio</title>
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
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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
        <h1>Add New Portfolio</h1>

        <!-- Show success or error messages -->
        <?php if (isset($success_message)): ?>
            <div class="success-message">
                <?= $success_message ?>
                <script>
                    alert("New Portfolio Added Successfully!");
                    window.location.href = "member_portfolio.php";
                </script>
            </div>
            
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?= $error_message ?></div>
        <?php endif; ?>

        <!-- Form to add a new portfolio -->
        <form method="POST" action="member_add_new_portfolio.php">
            <!-- Currency Pairing Dropdown -->
            <label for="currency_pairing">Currency Pairing</label>
            <select name="currency_pairing" id="currency_pairing" required>
                <?php foreach ($forex_pairs as $pair): ?>
                    <option value="<?= $pair ?>"><?= $pair ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Profit Goal (Only integers with 3 decimal places) -->
            <label for="profit_goal">Profit Goal</label>
            <input type="text" name="profit_goal" id="profit_goal" placeholder="Enter Profit Goal (e.g. 10.000)" 
                   pattern="^\d+(\.\d{3})$" title="Enter a number with exactly 3 decimal places (e.g., 10.000)" required>

            <!-- Lot Size (Must be greater than 0.01) -->
            <label for="lot_size">Lot Size</label>
            <input type="number" step="0.01" name="lot_size" id="lot_size" placeholder="Enter Lot Size" min="0.01" required>

            <!-- Date of Entry -->
            <label for="date_of_entry">Date of Entry</label>
            <input type="date" name="date_of_entry" id="date_of_entry" max="<?= date('Y-m-d') ?>" required>

            <!-- Submit Button -->
            <input type="submit" value="Add Portfolio">
        </form>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
