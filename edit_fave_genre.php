<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    require('header.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    $user_id = $_SESSION['user_id'];
    $new_genre = $_POST['fave_genre'];

    $sql = "UPDATE users 
    SET fave_genre = :new_genre
    WHERE user_id = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(':new_genre'=>$new_genre, ':user_id'=>$user_id));
    $result = $query->rowCount();
    $query->closeCursor();
    $db = null;

    if ($result > 0) {
        header("Location: myprofile.php?msg=Το αγαπημένο σου είδος άλλαξε με επιτυχία!");
        exit();
    } else {
        header("Location: myprofile.php?msg=Αποτυχία αλλαγής!");
        exit();
    }
    ob_end_flush();

?>