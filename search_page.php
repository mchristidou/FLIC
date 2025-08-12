<?php
    session_start();

    require('db_conn.php');

    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $search_value = $_GET['search_value'];

    if (isset($_GET['search_value'])) { // if the search button is clicked

        $input = $_GET['search_value']; // get search value

        if (!empty($input)) { //if search value isn't empty
            
            //users
            $sql = "SELECT user_id, username FROM users WHERE ";
            $params = [];
            $sql .= "username LIKE :search_value";
            $params[':search_value'] = "%$search_value%";
            $query = $db->prepare($sql);
            $query->execute($params);

            //movies
            $movies_sql = "SELECT movie_id, title FROM movies WHERE ";
            $params = [];
            $movies_sql .= "title LIKE :search_value";
            $params[':search_value'] = "%$search_value%";
            $movies_query = $db->prepare($movies_sql);
            $movies_query->execute($params);

            //reviews
            $reviews_sql = "SELECT review_id, user_id, reviews.movie_id, title FROM reviews JOIN movies ON reviews.movie_id = movies.movie_id WHERE ";
            $params = [];
            $reviews_sql .= "title LIKE :search_value";
            $params[':search_value'] = "%$search_value%";
            $reviews_query = $db->prepare($reviews_sql);
            $reviews_query->execute($params);

            //lists
            $lists_sql = "SELECT list_id, title FROM lists WHERE ";
            $params = [];
            $lists_sql .= "title LIKE :search_value";
            $params[':search_value'] = "%$search_value%";
            $lists_query = $db->prepare($lists_sql);
            $lists_query->execute($params);
        } 
    } 
?>

<main id="main" class="flex-grow-1">

    <div class="container container-expand-sm" style="margin-top:50px; padding:15px; width:200;">
        <h2>Search results for "<?php echo $search_value; ?>"</h2><br/>

        <?php echo_msg(); ?>

        <h3>Users</h3>
        <?php if (!empty($input)) { 
            if ($query->rowCount() == 0) { ?>
                <p>No results found</p>
            <?php } else { 
                while($users = $query->fetch()) { ?>
                    <a href="public_profile.php?search_value=<?php echo $users['username']; ?>&user_id=<?php echo $users['user_id']; ?>">
                        <?php echo $users['username'].'<br/>';?>
                    </a>
                <?php } 
            } $query->closeCursor(); ?>

            <br/>

            <h3>Movies</h3>            
            <?php if ($movies_query->rowCount() == 0) { ?>
                <p>No results found</p>
            <?php } else { 
                while($movies = $movies_query->fetch()) { ?>
                    <a href="movie_page.php?search_value=<?php echo $movies['title']; ?>&movie_id=<?php echo $movies['movie_id']; ?>">
                        <?php echo $movies['title'].'<br/>'; ?> <!-- cards -->
                    </a>
                <?php } 
            } ?>

            <br/>

            <h3>Reviews</h3>           
            <?php if ($reviews_query->rowCount() == 0) { ?>
                <p>No results found</p>
            <?php } else { 
                while($reviews = $reviews_query->fetch()) {
                    $user = $reviews['user_id'];
                    $creator_sql = "SELECT username FROM users WHERE user_id = :user";
                    $creator_query = $db->prepare($creator_sql);
                    $creator_query->execute(array(':user'=>$user));
                    $creator = $creator_query->fetch(); ?>

                    <a href="open_review.php?review_id=<?php echo $reviews['review_id']; ?>&creator=<?php echo $creator['username']; ?>">
                        <?php echo $reviews['title'].'<br/>';?> <!-- cards -->
                    </a>

                <?php } 
                $creator_query->closeCursor();
                $movies_query->closeCursor();
                $reviews_query->closeCursor();
            } ?>

            <br/>

            <h3>Lists</h3>           
            <?php if ($lists_query->rowCount() == 0) { ?>
                <p>No results found</p>
            <?php } else { 
                while($lists = $lists_query->fetch()) { ?>
                    <a href="open_list.php?list_id=<?php echo $lists['list_id']; ?>">
                        <?php echo $lists['title'].'<br/>';?> <!-- cards -->
                    </a>
                <?php }
            }
            
            $lists_query->closeCursor();
            $db = null;

        } else { ?>
            <p>No results found</p>
        <?php } ?>
        
    </div>
    
</main>

<?php require('footer.php'); ?>