<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');
    require('footer.php');

    $button = $_GET['submit'];
    $review_id = $_GET['review_id'];
    $rating = $_GET['edit_rating'];
    $review_text = $_GET['review_text'];
    $user_id = $_SESSION['user_id'];

    $data = [
        ':review_id' => $review_id,
        ':rating' => $rating,
        ':review_text' => $review_text,
        ':user_id' => $user_id,
    ];

    if ($button == "edit") {
        $sql = "UPDATE reviews 
        SET rating=:rating, review_text=:review_text 
        WHERE user_id = :user_id and review_id = :review_id";
        $query = $db->prepare($sql);
        $query->execute($data);
        $res = $query->rowCount();
        $query->closeCursor();

        if ($res > 0) {
            header("Location: reviews_page.php?msg=Επιτυχής Αλλαγή!");
            exit();
        } else {
            header("Location: reviews_page.php?msg=Αδυναμία Αλλαγής!");
            exit();
        }

        $query->closeCursor();
        $db = null;
        ob_end_flush();

    }   
    
    require('footer.php');
?>