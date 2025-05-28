<?php 
    session_start();
    require('db_conn.php');

    $user_id = $_SESSION['user_id'];
    $list_id = $_GET['list_id'];

    $sql = "DELETE FROM list_likes WHERE user_id = :user_id AND list_id = :list_id";
    $query = $db->prepare($sql);
    $query->execute(array(':user_id'=>$user_id, ':list_id'=>$list_id));
    $res = $query->rowCount();

    if ($res == 0) {
        $sql = "INSERT INTO list_likes VALUES (:user_id, :list_id)";
        $query = $db->prepare($sql);
        $query->execute(array(':user_id'=>$user_id, ':list_id'=>$list_id));
        $result = $query->rowCount();
    }

    header('Location: open_list.php?list_id='.$list_id);
    //exit(); 

?>