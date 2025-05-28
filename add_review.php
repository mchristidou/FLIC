<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    $user_id = $_SESSION['user_id'];
    $movie_id = $_GET['movie_id'];
    $rating = $_GET['rating'];
    $review_text = $_GET['review_text'];

    if (is_null($movie_id)) {
        $movie_title = $_GET['movie_title'];
        $sql2 = "SELECT movie_id FROM movies WHERE title = :movie_title";
        $query = $db->prepare($sql2);
        $query->execute(array(':movie_title' => $movie_title));
        $record = $query->fetch();
        $query->closeCursor();
    
        $movie_id = $record['movie_id'];
    
        $data = [
            ':user_id' => $user_id,
            ':movie_id' => $movie_id,
            ':rating' => $rating,
            ':review_text' => $review_text 
        ];
    } else {
        $data = [
            ':user_id' => $user_id,
            ':movie_id' => $movie_id,
            ':rating' => $rating,
            ':review_text' => $review_text 
        ];
    }

    $sql = "SELECT movie_id FROM reviews WHERE user_id=:user_id and movie_id=:movie_id";
    $query = $db->prepare($sql);
    $query->execute(array(':user_id'=>$user_id,':movie_id' => $movie_id));
    $record = $query->rowCount();
    if ($record == 0){
        $sql2 = "INSERT INTO reviews(user_id, movie_id, rating, review_text) VALUES (:user_id, :movie_id, :rating, :review_text)";
        $query2 = $db->prepare($sql2);
        $query2->execute($data);
        $result = $query2->rowCount();
        $query2->closeCursor();

        if ($result > 0) {
            header("Location: reviews_page.php?msg=Η κριτική δημιουργήθηκε επιτυχώς!");
            exit();
        }

    } else {
        header("Location: reviews_page.php?msg=Έχεις ήδη βαθμολογήσει αυτή τη ταινία!");
        exit();
    }

    $query->closeCursor();

    if ($result <= 0) {
        header("Location: reviews_page.php?msg=Αδυναμία δημιουργίας!");
        exit();
    }
    ob_end_flush();
    
?>