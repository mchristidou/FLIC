<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $user_id = $_SESSION['user_id'];
    $review_id = $_GET['review_id'];
    $comment = $_POST['comment'];

    $sql1 = "SELECT username FROM users WHERE user_id=:user_id";
    $query1 = $db->prepare($sql1);
    $query1->execute(array(':user_id'=>$user_id));
    $result = $query1->fetch();
    $username = $result['username'];
    
    $sql2 = "INSERT INTO review_comments(user_id, review_id, comment) VALUES (:user_id, :review_id, :comment)";
    $query2 = $db->prepare($sql2);
    $query2->execute(array(':user_id'=>$user_id, ':review_id'=>$review_id, ':comment'=>$comment));
    $result = $query2->rowCount();
    $query2->closeCursor();
    
    if ($result > 0) {
        header("Location: open_review.php?review_id=".$review_id."&creator=".$username);
        exit();
    } else {
        header("Location: open_review.php?review_id=".$review_id."&creator=".$username);
        exit();
    }

    $query1->closeCursor();
    $db = null;
    ob_end_flush();

    
?>