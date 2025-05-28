<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $button = $_GET['submit'];
    $review_id = $_GET['review_id'];
    $user_id = $_SESSION['user_id'];

    $data = [
        ':review_id' => $review_id,
        ':user_id' => $user_id,
    ];

    if ($button == "del") {
        $sql = "DELETE FROM reviews 
        WHERE user_id = :user_id 
        AND review_id = :review_id";
        $query = $db->prepare($sql);
        $query->execute($data);
        $result = $query->rowCount();
        $query->closeCursor();
        $db = null;

        if ($result > 0){
            header("Location: reviews_page.php?msg=Επιτυχής Διαγραφή!");
        }
    }
    
    ob_end_flush();
    
    require('footer.php');
?>