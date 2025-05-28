<?php 
    session_start();

    require('db_conn.php');

    $action = $_GET['action']; // Get action: follow/unfollow
    $user_id = $_GET['user_id'];

    $data = [
        ':user_id1' => $_SESSION['user_id'],
        ':user_id2' => $user_id
    ];

    $sql = "SELECT username FROM users WHERE user_id = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(':user_id'=>$user_id));
    $result = $query->fetch();
    $username = $result['username'];
    $query->closeCursor();

    if ($action == 'follow') {
        $sql = "INSERT INTO friends VALUES (:user_id1, :user_id2)";
        $query = $db->prepare($sql);
        $query->execute($data);
        $record = $query->rowCount();
        if ($record > 0) {
            //success
            header("Location: public_profile.php?search_value=$username&user_id=$user_id&msg=Followed Successfully!");
            exit();
        } else {
            //error
            header("Location: public_profile.php?search_value=$username&user_id=$user_id&msg=Error!");
            exit();
        }
    } else if ($action == 'unfollow') {
        $sql = "DELETE FROM friends WHERE user_id1 = :user_id1 AND user_id2 = :user_id2";
        $query = $db->prepare($sql);
        $query->execute($data);
        $record = $query->rowCount();
        if ($record > 0) {
            //success
            header("Location: public_profile.php?search_value=$username&user_id=$user_id&msg=Unfollowed Successfully!");
            exit();
        } else {
            //error
            header("Location: public_profile.php?search_value=$username&user_id=$user_id&msg=Error!");
            exit();
        }
    }
    
    $query->closeCursor();
    $db = null;

?>