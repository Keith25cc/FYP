<?php
    session_start();

    if (isset($_SESSION["member_id"])) {
        include("member_header.php");
    } else {
        include("before_login_header.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forex Market News</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .news-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: black;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: white;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .news-item {
            margin-bottom: 30px;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            color:white;
        }

        .news-item h2 {
            font-size: 24px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .news-item p {
            font-size: 18px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="news-container">
        <h1>Latest Forex Market News</h1>
        <div id="news-list">
            <!-- News items will be dynamically loaded here -->
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('https://newsapi.org/v2/everything?q=forex&apiKey=b4faac17d0c54865bd894c02c9e94943')
                .then(response => response.json())
                .then(data => {
                    const newsList = document.getElementById('news-list');
                    if (data.articles) {
                        data.articles.forEach(article => {
                            const newsItem = document.createElement('div');
                            newsItem.className = 'news-item';
                            newsItem.innerHTML = `
                                <h2><a href="${article.url}" target="_blank">${article.title}</a></h2>
                                <p>${article.description}</p>
                            `;
                            newsList.appendChild(newsItem);
                        });
                    }
                })
                .catch(error => {
                    const newsList = document.getElementById('news-list');
                    newsList.innerHTML = '<p>Unable to fetch the latest news. Please try again later.</p>';
                });
        });
    </script>
</body>
</html>
