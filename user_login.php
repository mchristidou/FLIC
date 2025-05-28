<?php
    
    if ( !isset($_SESSION['username']) && isset($_POST['username'], $_POST['password']) ) {
        
        require('db_conn.php');
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        

        $sql = "SELECT * FROM users WHERE username=:username";
        $query = $db->prepare($sql);
        $query->execute(array(':username'=>$username));
        $result = $query->fetch();
        $query->closeCursor();
        $db = null;

        $hash = password_hash($password, PASSWORD_DEFAULT); //cryptographic salt for the password
      
        $authorised=false;
      
        if ($result == true && password_verify($_POST['password'], $hash)) {   //found in db
            $authorised= true;  
            session_start();    // session for user starts
            $_SESSION['username']= $result['username'];  //we record the user in session
            $_SESSION['user_id']= $result['user_id'];
            $_SESSION['fave_genre'] = $result['fave_genre']; //is ti good?
            $_SESSION['avatar'] = $result['avatar']; //is it good?
        }
      
        if ($authorised==true) {  
            header('Location: films_page.php'); //user page
            exit();
        } 
        else {
            header("Location: login.php?msg=Αποτυχημένη διαπίστευση χρήστη!"); //error
            exit();
        }
    } else {
        session_start();    
        session_destroy();
        header("Location: login.php?msg=Πρόβλημα - Δοκίμασε ξανά!");
        exit(); 
    }

?>