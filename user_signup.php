<?php

    /*ΣΥΝΔΕΣΗ ΣΤΗ ΒΑΣΗ*/
    require('db_conn.php');

    /*ΕΓΓΡΑΦΗ ΧΡΗΣΤΗ */

    $username = $_POST['username'];
    $password = $_POST['password'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $email_conf = $_POST['email_conf'];
    $fave_genre = $_POST['fave_genre'];

    $usr_str = strlen($username);
    $ps_str = strlen($password);

    $ps_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/';

    $sql = "SELECT username FROM users WHERE username=:username";
    $query = $db->prepare($sql);
    $query->execute(array(':username'=>$username));
    $result = $query->fetch();

    if ($result == true){ //username was found in the db
        header("Location: signup.php?msg=Υπάρχει χρήστης με αυτό το username!");
        exit();
    }

    if ($usr_str < 8 || $usr_str > 15) {
        header("Location: signup.php?msg=Το username δεν έχει 8-15 χαρακτήρες!");
        exit();
    }

    if ($ps_str < 8) {
        header("Location: signup.php?msg=Ο κωδικός πρόσβασης είναι μικρός!");
        exit();
    } else if (!preg_match($ps_pattern, $password)) {
        header("Location: signup.php?msg=Ο κωδικός πρόσβασης δεν είναι κατάλληλος. Ξαναπροσπάθησε!");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?msg=Μη αποδεκτό email!");
        exit();
    } /*not sure if needed*/

    $hash = password_hash($password, PASSWORD_DEFAULT); //applying cryptographic salt to password

    $data = [
        ':username' => $username,
        ':password' => $hash,
        ':birthday' => $birthday,
        ':email' => $email,
        ':fave_genre' => $fave_genre,
    ];
    $sql = "INSERT INTO users(username, password, date_of_birth, email, fave_genre) VALUES (:username,:password,:birthday,:email,:fave_genre)";
    $query = $db->prepare($sql);
    $query->execute($data);
    $result = $query->fetch();
    $query->closeCursor();
    $db = null;

    header("Location: login.php?msg=Επιτυχής εγγραφή!");
    

?>