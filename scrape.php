<?php
require_once 'db.php'; // Database connection
require_once 'simple_html_dom.php'; // Include simple_html_dom library

// List of trusted news sources with their URLs
$news_sources = [
    ['name' => 'BBC', 'url' => 'https://www.bbc.com/news'],
    ['name' => 'CNN', 'url' => 'https://edition.cnn.com/'],
    ['name' => 'Reuters', 'url' => 'https://www.reuters.com/']
    // Add more sources as needed
];

try {
    foreach ($news_sources as $source) {
        $response = file_get_contents($source['url']); // Fetch webpage content
        $html = new simple_html_dom();
        $html->load($response);

        // Adjust the selector and logic based on the structure of each source's HTML
        $articles = $html->find('article'); // Example: Find all <article> elements

        foreach ($articles as $article) {
            $titleElement = $article->find('h3', 0); // Example: Find first <h3> within each <article>
            $linkElement = $article->find('a', 0); // Example: Find first <a> tag within each <article>

            if ($titleElement && $linkElement) {
                $title = $titleElement->plaintext; // Get the plain text of the article title
                $link = $linkElement->href; // Get the href attribute of the first <a> tag inside <h3>

                // Insert into database
                $stmt = $pdo->prepare("INSERT INTO news (source, title, link) VALUES (:source, :title, :link)");
                $stmt->execute(['source' => $source['name'], 'title' => $title, 'link' => $link]);
            }
        }

        $html->clear(); // Clean up memory
        unset($html);
    }

    echo "Scraping and storing successful!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
