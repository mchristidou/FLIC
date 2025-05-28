<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    require('header.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    $user_id = $_SESSION['user_id'];
    $new_email = $_POST['email'];

    $sql = "UPDATE users 
    SET email = :new_email 
    WHERE user_id = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(':new_email'=>$new_email, ':user_id'=>$user_id));
    $result = $query->rowCount();
    $query->closeCursor();
    $db = null;

    if ($result > 0) {
        header("Location: myprofile.php?msg=Το email άλλαξε επιτυχώς!");
        exit();
    } else {
        header("Location: myprofile.php?msg=Αποτυχία Αλλαγής!");
        exit();
    }
    ob_end_flush();

?>