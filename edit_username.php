<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    require('header.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    $user_id = $_SESSION['user_id'];
    $new_username = $_POST['username'];

    $sql = "UPDATE users 
    SET username = :new_username 
    WHERE user_id = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(':new_username'=>$new_username, ':user_id'=>$user_id));
    $result = $query->rowCount();
    $query->closeCursor();
    $db = null;

    if ($result > 0) {
        header("Location: myprofile.php?msg=Το username άλλαξε επιτυχώς!Για να το δεις, ξανακάνε login!");
        exit();
    } else {
        header("Location: myprofile.php?msg=Αποτυχία Αλλαγής!");
        exit();
    }
    ob_end_flush();

?>