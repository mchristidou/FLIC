<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $user_id = $_SESSION['user_id'];
    $list_id = $_GET['list_id'];
    $movie_id = $_GET['movie_id'];

    $data = [
        ':list_id' => $list_id,
        ':user_id' => $user_id,
        ':movie_id' => $movie_id
    ];

    try{
        $sql = "INSERT INTO list_contents(list_id, user_id, movie_id) VALUES (:list_id, :user_id, :movie_id)";
        $query = $db->prepare($sql);
        $query->execute($data);
        $result = $query->rowCount();
        $query->closeCursor();
        $db = null;
    }catch(PDOException $error){
        header("Location: movie_page.php?movie_id=" . $movie_id . "&msg=Η ταινία υπάρχει ήδη στην λίστα!");
        exit();
    }
    
    
    if ($result > 0) {
        header("Location: movie_page.php?movie_id=" . $movie_id . "&msg=Η ταινία προστέθηκε επιτυχώς!");
        exit();
    } else {
        header("Location: movie_page.php?movie_id=" . $movie_id . "&msg=Αδυναμία προσθήκης!");
        exit();
    }
    ob_end_flush();
?>

<?php require('footer.php'); ?>
