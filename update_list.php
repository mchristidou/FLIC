<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $button = $_GET['submit'];
    $list_id = $_GET['list_id'];
    $list_title = $_GET['list_title'];
    $user_id = $_SESSION['user_id'];

    $data = [
        ':list_id' => $list_id,
        ':list_title' => $list_title,
        ':user_id' => $user_id,
    ];

    if ($button == "rename") {
        $sql = "UPDATE lists SET title=:list_title WHERE user_id = :user_id and list_id = :list_id";
        $query = $db->prepare($sql);
        $query->execute($data);
        $result = $query->rowCount();
        
        if ($result > 0) {
            header("Location: lists_page.php?msg=Επιτυχής Αλλαγή!");
            exit();
        } else {
            header("Location: lists_page.php?msg=Αδυναμία Αλλαγής!");
            exit();
        }

        $query->closeCursor();
        $db = null;
        ob_end_flush();

    } 
    
    require('footer.php');

?>