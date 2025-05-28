<?php
    session_start();

    require('db_conn.php');

    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $search_value = $_GET['search_value'];

    if (isset($_GET['search_value'])) { // if the search button is clicked

        $username = $_GET['search_value']; // get search value

        if (!empty($username)) { //if search value isn't empty
            $sql = "SELECT user_id, username FROM users WHERE ";
            $params = [];
            $sql .= "username LIKE :value";
            $params[':value'] = "%$search_value%";
            $query = $db->prepare($sql);
            $query->execute($params);
        } 
    } 
?>

<main id="main" class="flex-grow-1">

    <div class="container container-expand-sm" style="margin-top:50px; padding:15px; width:200;">
        <h2>Search results for "<?php echo $search_value; ?>"</h2>

        <?php echo_msg(); ?>

        <?php if (!empty($username)) { 
            if ($query->rowCount() == 0) { ?>
                <p>No results found</p>
            <?php } else { 
                while($result = $query->fetch()) { ?>
                    <a href="public_profile.php?search_value=<?php echo $result['username']; ?>&user_id=<?php echo $result['user_id']; ?>">
                        <?php echo $result['username'].'<br/>';?>
                    </a>
                <?php } 
            }
            $query->closeCursor();
            $db = null;
        } else { ?>
            <p>No results found</p>
        <?php } ?>
        
    </div>
    
</main>

<?php require('footer.php'); ?>