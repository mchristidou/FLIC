<?php 
    ob_start();
    session_start();

    require('db_conn.php');

    $user_id = $_SESSION['user_id'];
    $new_avatar = $_POST['selectedAvatar'];

    $sql = "UPDATE users
    SET avatar = :new_avatar
    WHERE user_id = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(':new_avatar'=>$new_avatar, ':user_id'=>$user_id));
    $result = $query->rowCount();
    $query->closeCursor();

    if ($result > 0) {
        header("Location: myprofile.php?msg=Επιτυχία!Για να δεις την αλλαγή, συνδέσου ξανά!");
        exit();
    } else {
        header("Location: myprofile.php?msg=Αποτυχία!");
        exit();
    }
    $db = null;
    ob_end_flush();





?>