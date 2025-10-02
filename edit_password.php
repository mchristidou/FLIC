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
        header("Location: myprofile.php?msg=Οι κωδικοί πρόσβασης δεν ταιριάζουν!");
        exit();
    } else if ($old_password_hashed !== password_verify($new_password, $old_password_hashed)) {
        header("Location: myprofile.php?msg=Ο νέος κωδικός πρόσβασης πρέπει να είναι διαφορετικός από τον παλιό!");
        exit();
    } else if (empty($new_password) || empty($new_passwordconf)) {
        header("Location: myprofile.php?msg=Συμπλήρωσε όλα τα πεδία!");
        exit();
    } else if (!password_verify($new_password, $old_password_hashed)) {
        header("Location: myprofile.php?msg=Λανθασμένος κωδικός πρόσβασης!");
        exit();
    }
    else if (strlen($new_password) < 8) {
        header("Location: myprofile.php?msg=Ο κωδικός πρόσβασης πρέπει να είναι τουλάχιστον 8 χαρακτήρες!");
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
        header("Location: myprofile.php?msg=Ο κωδικός πρόσβασης άλλαξε με επιτυχία!");
        exit();
    } else {
        header("Location: myprofile.php?msg=Αποτυχία αλλαγής!");
        exit();
    }
    ob_end_flush();

?>