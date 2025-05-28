<?php 
    ob_start();
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');

    $list_title = $_GET['list_title'];
    $user_id = $_SESSION['user_id'];

    $data = [
        ':list_title' => $list_title,
        ':user_id' => $user_id,
    ];

    $sql2 = "SELECT title FROM lists WHERE user_id = :user_id and title = :list_title";
    $query = $db->prepare($sql2);
    $query->execute($data);
    $record = $query->fetch();
    $query->closeCursor();
    

?>

<main id="main" class="flex-grow-1">
    <h1>Λίστες</h1>
    <?php 
        if ($record == true) {
            header("Location: lists_page.php?msg=Έχεις ήδη λίστα με το ίδιο όνομα!");
            exit();
        }

        $sql = "INSERT INTO lists(title, user_id) VALUES (:list_title, :user_id)";
        $query = $db->prepare($sql);
        $query->execute($data);
        $result = $query->rowCount();
        $query->closeCursor();
        $db = null;
        
        if ($result > 0) {
            header("Location: lists_page.php?msg=Η λίστα δημιουργήθηκε επιτυχώς!");
            exit();
        } else {
            header("Location: lists_page.php?msg=Αδυναμία δημιουργίας!");
            exit();
        }
        ob_end_flush();
    ?>
</main>

<?php require('footer.php'); ?>