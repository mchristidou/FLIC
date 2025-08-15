
<?php
require('db_conn.php');

// Check if the search query is set
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q === '') { exit; }

// Prepare and execute the SQL statement to search for movies
$sql = "SELECT movie_id, title FROM movies WHERE title LIKE :title LIMIT 10";
$stmt = $db->prepare($sql);
$stmt->execute([':title' => "%$q%"]);

// Check if any results were found
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = htmlspecialchars($row['movie_id']);
    $title = htmlspecialchars($row['title']);
    echo "<div class='list-group-item list-group-item-action' 
             style='cursor:pointer' 
             onclick='selectMovie(\"$id\", " . json_encode($title) . ")'>
             $title
          </div>";
}

