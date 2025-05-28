<?php 
    //NOT SURE IF I'LL USE THIS FILE!
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    $user_id = $_SESSION['user_id'];
    $review_id = $_POST['review_id'];
    $new_review = $_POST['new_review'];

    $sql = "UPDATE review_comments
    SET review_text = :new_review
    WHERE user_id = :user_id AND review_id = :review_id";
    $query = $db->prepare($sql);
    $query->execute(array(':new_review'=>$new_review, ':user_id'=>$user_id, ':review_id'=>$review_id));
    $result = $query->rowCount();
    $query->closeCursor();
    $db = null;

    if ($result > 0) {
        header("Location: open_review.php?msg=Επιτυχία Αλλαγής!");
        exit();
    } else {
        header("Location: open_review.php?msg=Αποτυχία Αλλαγής!");
        exit();
    }
    ob_end_flush();

?>