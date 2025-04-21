<?php
session_start();
include("connect_database.php");
include("member_header.php");

$member_id = $_SESSION["member_id"];

$account_query = "SELECT account_balance FROM member_info WHERE member_id = '$member_id'";
$account_result = mysqli_query($conn, $account_query);
$account_row = mysqli_fetch_assoc($account_result);
$account_balance = $account_row['account_balance'];

$query = "SELECT * FROM member_portfolio WHERE member_id = '$member_id'";
$result = mysqli_query($conn, $query);

$pairings = [];
$lot_sizes = [];
$total_lot_size = 0;

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
    <title>My Portfolio</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        html,body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            margin: 0; 
            padding: 0; 
            height:100%;
            overflow-x: hidden;
            z-index:1;
        }

        .portfolio-container { 
            width: 90%; 
            margin: 60px auto; 
            background: white; 
            padding: 20px; 
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); 
        }

        h1 { 
            text-align: center; 
            font-size: 36px; 
            margin-bottom: 30px; 
        }
        
        .pairing-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px; 
        }

        .pairing-table th, .pairing-table td { 
            padding: 10px; 
            border: 1px solid #ddd; 
            text-align: center; 
        }

        .pairing-table th { 
            background-color: black; 
            color: white; 
        }

        .chart-container { 
            margin: 30px auto; 
            width: 50%;
            height: 300px;
        }

        #lotSizeChart { 
            width: 100%; 
            height: 300px;
        }

        .btn {
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-add {
            background-color: #FF5733;
            margin:10px 5px auto auto; 
        }

        .btn-add:hover {
            background-color: #C4451C;
            transform: scale(1.05);  
        }

        .btn-edit {
            background-color: #FF5733; 
        }

        .btn-edit:hover {
            background-color: #C4451C;
            transform: scale(1.05);  
        }

        .btn-details {
            background-color: #28A745;
        }

        .btn-details:hover {
            background-color: #218838;  
            transform: scale(1.05);  
        }

        .btn-delete {
            background-color: #C4451C;
        }

        .btn-delete:hover {
            background-color: #C4451C;
            transform: scale(1.05);  
        }

        td button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="portfolio-container">
        <div>
            <h1>My Portfolio</h1>
            <button class='btn btn-add' onclick= "window.location.href='member_add_new_portfolio.php'">Add New Portfolio</button>
        </div>

        <div class="chart-container">
            <canvas id="lotSizeChart"></canvas>
        </div>

        <h2>Total Balance: <span id="totalBalance">0.00 USD</span></h2>
        <h2>Total Profit/Loss: <span id="totalProfitLoss">0.00 USD</span></h2>

        <table class="pairing-table">
            <thead>
                <tr>
                    <th>Pairing</th>
                    <th>Current Price</th>
                    <th>Enter Price</th>
                    <th>Date of entry</th>
                    <th>Lot Size</th>
                    <th>Profit/Loss (USD)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_profit_loss = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $pairing = $row["currency_pairing"];
                    $goal_price = $row["profit_goal"];
                    $date_of_entrance = $row["date_of_entry"];
                    $lot_size = $row["lot_size"];
                    $current_price = getLivePrice($pairing);
                    $profit_loss = calculateProfitLoss($current_price, $goal_price, $lot_size);
                    $total_profit_loss += $profit_loss;

                    $pairings[] = $pairing;
                    $lot_sizes[] = $lot_size;
                    $total_lot_size += $lot_size;

                    echo "
                        <tr>
                            <td>{$pairing}</td>
                            <td>" . number_format($current_price, 4) . "</td>
                            <td>{$goal_price}</td>
                            <td>{$date_of_entrance}</td>
                            <td>{$lot_size}</td>
                            <td>" . number_format($profit_loss, 2) . " USD</td>
                            <td>
                                <button class='btn btn-edit' onclick=\"window.location.href='update_profile_member_edit_portfolio.php?pairing=$pairing'\">Edit</button>
                                <button class='btn btn-details' onclick=\"window.location.href='member_portfolio_details_page.php?id={$row['portfolio_id']}'\">Details</button>
                                <button class='btn btn-delete' onclick=\"deletePortfolio({$row['portfolio_id']})\">Delete</button>
                            </td>
                        </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>

        function deletePortfolio(portfolioId) {
            if (confirm("Are you sure you want to delete this portfolio?")) {
                window.location.href = `delete_portfolio.php?id=${portfolioId}`;
            }
        }
        const accountBalance = <?= $account_balance ?>;
        const totalProfitLoss = <?= $total_profit_loss ?>;
        const totalBalance = accountBalance + totalProfitLoss;

        document.getElementById('totalBalance').innerText = totalBalance.toFixed(2) + " USD";
        document.getElementById('totalProfitLoss').innerText = totalProfitLoss.toFixed(2) + " USD";

        const pairings = <?= json_encode($pairings) ?>;
        const lotSizes = <?= json_encode($lot_sizes) ?>;
        const totalLotSize = <?= $total_lot_size ?>;

        const lotSizePercentages = lotSizes.map(function(size) {
            return ((size / totalLotSize) * 100).toFixed(2);
        });

        const ctx = document.getElementById('lotSizeChart').getContext('2d');
        const lotSizeChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: pairings,
                datasets: [{
                    label: 'Lot Size (%)',
                    data: lotSizePercentages,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                return `${label}: ${value}%`;
                            }
                        }
                    }
                }
            }
        });
    </script>

    <?php
        include("footer.php")
    ?>
</body>
</html>

