<?php 
    session_start();
    require('db_conn.php');

    $user_id = $_SESSION['user_id'];
    $review_id = $_GET['review_id'];

    $sql = "DELETE FROM review_likes WHERE user_id = :user_id AND review_id = :review_id";
    $query = $db->prepare($sql);
    $query->execute(array(':user_id'=>$user_id, ':review_id'=>$review_id));
    $res = $query->rowCount();

    if ($res == 0) {
        $sql = "INSERT INTO review_likes VALUES (:user_id, :review_id)";
        $query = $db->prepare($sql);
        $query->execute(array(':user_id'=>$user_id, ':review_id'=>$review_id));
        $result = $query->rowCount();
    }

    header('Location: reviews_page.php');
    //exit(); 

?>