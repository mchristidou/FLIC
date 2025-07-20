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

    // Update session variable - to be able to see the change immediately
    $_SESSION['avatar'] = $new_avatar;

    $query->closeCursor();

    if ($result > 0) {
        header("Location: myprofile.php?msg=Επιτυχής αλλαγή εικόνας προφίλ!");
        exit();
    } else {
        header("Location: myprofile.php?msg=Αποτυχής αλλαγή εικόνας προφίλ!");
        exit();
    }
    $db = null;
    ob_end_flush();





?>