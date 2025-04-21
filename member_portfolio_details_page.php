<?php
session_start();
include("connect_database.php");
include("member_header.php");

if (isset($_GET['id'])) {
    $portfolio_id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "
    SELECT member_portfolio.*, member_info.account_balance 
    FROM member_portfolio 
    JOIN member_info ON member_portfolio.member_id = member_info.member_id 
    WHERE portfolio_id = '$portfolio_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $pairing = $row['currency_pairing'];
        $account_balance = $row['account_balance'];
        $goal_price = $row['profit_goal'];
        $date_of_entry = $row["date_of_entry"];
        $lot_size = $row['lot_size'];
        $current_price = getLivePrice($pairing); // Fetch from the text file
        $profit_loss = calculateProfitLoss($current_price, $goal_price, $lot_size);
        $current_balance = $account_balance + $profit_loss;
        $current_date = date('Y-m-d');
    } else {
        echo "<p>No portfolio found for this ID.</p>";
        exit;
    }
} else {
    echo "<p>No portfolio ID specified.</p>";
    exit;
}

// Function to calculate Profit/Loss
function calculateProfitLoss($current_price, $goal_price, $lot_size) {
    return round($lot_size * 10 * ($current_price - $goal_price), 2);
}

// Function to get live price from preset text file
function getLivePrice($pair) {
    // Path to the text file
    $file_path = "forex_price/latest_forex_prices.txt";
    
    // Read the file content
    $file_content = file_get_contents($file_path);
    
    // Convert file content into an array
    $lines = explode("\n", trim($file_content));
    $prices = [];
    
    // Parse each line to extract the pairing and its price
    foreach ($lines as $line) {
        preg_match('/"([^"]+)"\s*=>\s*([\d\.]+)/', $line, $matches);
        if ($matches) {
            $prices[$matches[1]] = (float) $matches[2];
        }
    }

    // Return the price of the specific pairing if available
    $pair_key = "{$pair}=X";  // Format the pair to match the keys in the text file
    return $prices[$pair_key] ?? 0;  // Return 0 if pairing is not found
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Details</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .title {
            font-size: 36px;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details-table th, .details-table td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .details-table th {
            background-color: #4CAF50;
            color: white;
        }

        .details-table td {
            background-color: #f9f9f9;
        }

        .chart-container {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Portfolio Details for <?= $pairing ?></h1>
        <table class="details-table">
            <thead>
                <tr>
                    <th>Pairing</th>
                    <th>Current Price</th>
                    <th>Enter Price</th>
                    <th>Date of Entrance</th>
                    <th>Lot Size</th>
                    <th>Profit/Loss (USD)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $pairing ?></td>
                    <td><?= number_format($current_price, 4) ?></td>
                    <td><?= number_format($goal_price, 4) ?></td>
                    <td><?= $date_of_entry ?></td>
                    <td><?= $lot_size ?></td>
                    <td><?= number_format($profit_loss, 2) ?> USD</td>
                </tr>
            </tbody>
        </table>

        <div class="chart-container">
            <canvas id="balanceChart"></canvas>
        </div>
    </div>

    <script>
        const initialBalance = <?= $account_balance ?>;
        const currentBalance = <?= $current_balance ?>;
        const dateOfEntry = '<?= $date_of_entry ?>';
        const currentDate = '<?= $current_date ?>';

        const dates = [dateOfEntry, currentDate];
        const balances = [initialBalance, currentBalance];

        const ctx = document.getElementById('balanceChart').getContext('2d');
        const balanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Account Balance (USD)', 
                    data: balances,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Dates'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Balance (USD)'
                        },
                        beginAtZero: false
                    }
                }
            }
        });
    </script>

    <?php include("footer.php"); ?>
</body>
</html>
