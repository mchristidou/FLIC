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
    $rating = $_GET['rating'];
    $review_text = $_GET['review_text'];
    $user_id = $_SESSION['user_id'];

    $data1 = [
        ':review_id' => $review_id,
        ':rating' => $rating,
        ':user_id' => $user_id,
    ];

    $data2 = [
        ':review_id' => $review_id,
        ':review_text' => $review_text,
        ':user_id' => $user_id,
    ];

    if ($button == "edit") {
        $sql = "UPDATE reviews 
        SET rating=:rating 
        WHERE user_id = :user_id and review_id = :review_id";
        $query = $db->prepare($sql);
        $query->execute($data1);
        $rate_res = $query->rowCount();
        $query->closeCursor();

        $sql = "UPDATE reviews 
        SET review_text=:review_text 
        WHERE user_id = :user_id and review_id = :review_id";
        $query = $db->prepare($sql);
        $query->execute($data2);
        $text_res = $query->rowCount();
        

        if ($rate_res > 0 && $text_res > 0) {
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