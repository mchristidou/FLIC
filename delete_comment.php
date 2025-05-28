<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    require('header.php');

    $title = "FLIC - Film Lovers Interacting & Connecting";

    $user_id = $_SESSION['user_id'];
    $review_id = $_GET['review_id'];
    $comment_id = $_GET['comment_id'];

    $data = [
        ':user_id' => $user_id,
        ':review_id' => $review_id,
        ':comment_id' => $comment_id
    ];

    $sql = "SELECT username FROM users WHERE user_id = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(':user_id' => $user_id));
    $user = $query->fetch();
    $username = $user['username'];
    $query->closeCursor();

    $sql = "DELETE FROM review_comments WHERE user_id = :user_id AND review_id = :review_id AND comment_id = :comment_id;";
    $query = $db->prepare($sql);
    $query->execute($data);
    $result = $query->rowCount();
    $query->closeCursor();

    if ($result > 0) {
        header("Location: open_review.php?review_id=$review_id&creator=$username&msg=Επιτυχής Διαγραφή!");
        exit();
    } else {
        header("Location: open_review.php?review_id=$review_id&creator=$username&msg=Αδυναμία Διαγραφής!");
        exit();
    }
    $db = null;
    ob_end_flush();

?>