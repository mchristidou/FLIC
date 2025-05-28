<?php
    ob_start();
    session_start();

    $dbhost = "localhost";
    $dbname = "flic_db";
    $dbuser = "uth";
    $dbpass = "uth1234@";

    require('db_conn.php');

    $button = $_GET['submit'];
    $list_id = $_GET['list_id'];
    $list_title = $_GET['list_title'];
    $user_id = $_SESSION['user_id'];

    $data = [
        ':list_title' => $list_title,
        ':user_id' => $user_id,
    ];

    $sql = "SELECT * FROM list_contents WHERE list_id = :list_id;";
    $query = $db->prepare($sql);
    $query->execute(array(':list_id'=>$list_id));
    $result = $query->fetch();
    $query->closeCursor();

    if ($button == "del") {
        if (!$result) {
            $sql = "DELETE FROM list_contents WHERE user_id = :user_id AND list_id = :list_id;";
            $query = $db->prepare($sql);
            $query->execute(array(':user_id'=>$user_id, ':list_id'=>$list_id));
            $result = $query->rowCount();
            $query->closeCursor();
    
            $sql = "DELETE FROM lists WHERE user_id = :user_id AND title = :list_title";
            $query = $db->prepare($sql);
            $query->execute($data);
            $result = $query->rowCount();
            $query->closeCursor();
            $db = null;
        } else {
            $sql = "DELETE FROM lists WHERE user_id = :user_id AND title = :list_title";
            $query = $db->prepare($sql);
            $query->execute($data);
            $result = $query->rowCount();
            $query->closeCursor();
            $db = null;
        }
    }

    if ($result > 0){
        header("Location: lists_page.php?msg=Επιτυχής Διαγραφή!");
    } else {
        header("Location: lists_page.php?msg=Αποτυχία Διαγραφής!");
    }

    ob_end_flush();

    require('footer.php');
?>