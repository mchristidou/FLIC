<?php
    session_start(); 
    if(!isset($_SESSION['username'])){
        $_SESSION['msg']='Πρέπει να κάνεις login!';
        header("Location: login.php?msg=Πρέπει να κάνεις login!");
        exit();
    }
?>