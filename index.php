<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Aggregator</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Latest News</h1>
        <div id="news-list">
            <?php
            // Include database connection
            require_once 'db.php';

            try {
                // Fetch news data from the database
                $stmt = $pdo->query("SELECT * FROM news");
                $news_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Display news articles
                foreach ($news_data as $article) {
                    echo "<div class='news-item'>";
                    echo "<h2><a href='{$article['link']}' target='_blank'>{$article['title']}</a></h2>";
                    echo "<p>Source: {$article['source']}</p>";
                    echo "</div>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
    </div>
</body>
</html>
