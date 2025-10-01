<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    require('header.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    $user_id = $_SESSION['user_id'];
    $old_password_hashed = $_SESSION['password'];
    $new_password = $_POST['password'];
    $new_passwordconf = $_POST['passwordconf'];

    if ($new_password !== $new_passwordconf) {
        header("Location: myprofile.php?msg=Passwords don't match!");
        exit();
    } else if ($old_password_hashed !== password_verify($new_password, $old_password_hashed)) {
        header("Location: myprofile.php?msg=New password cannot be the same as the old one!");
        exit();
    } else if (empty($new_password) || empty($new_passwordconf)) {
        header("Location: myprofile.php?msg=Please fill in all fields!");
        exit();
    } else if (!password_verify($new_password, $old_password_hashed)) {
        header("Location: myprofile.php?msg=Incorrect password!");
        exit();
    }
    else if (strlen($new_password) < 8) {
        header("Location: myprofile.php?msg=Password must be at least 8 characters long!");
        exit();
    }

    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $_SESSION['password'] = $new_password_hashed;

    $sql = "UPDATE users 
    SET password = :new_password_hashed 
    WHERE user_id = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(':new_password_hashed'=>$new_password_hashed, ':user_id'=>$user_id));
    $result = $query->rowCount();
    $query->closeCursor();
    $db = null;

    if ($result > 0) {
        header("Location: myprofile.php?msg=The password changed successfully!");
        exit();
    } else {
        header("Location: myprofile.php?msg=Unsuccessful change!");
        exit();
    }
    ob_end_flush();

?>