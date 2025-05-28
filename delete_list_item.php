<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $list_id = $_GET['list_id'];
    $movie_id = $_GET['movie_id'];
    $user_id = $_SESSION['user_id'];

    $data = [
        ':list_id' => $list_id,
        ':user_id' => $user_id,
        ':movie_id' => $movie_id
    ];

    $sql = "DELETE FROM list_contents WHERE user_id = :user_id AND list_id = :list_id AND movie_id = :movie_id;";
    $query = $db->prepare($sql);
    $query->execute($data);
    $result = $query->rowCount();
    $query->closeCursor();

    if ($result > 0) {
        header("Location: lists_page.php?msg=Επιτυχής Διαγραφή!"); /*open_list*/
        exit();
    } else {
        header("Location: lists_page.php?msg=Αδυναμία Διαγραφής!");
        exit();
    }

    ob_end_flush();
    
    require('footer.php');
?>