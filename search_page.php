<?php
    session_start();

    require('db_conn.php');

    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $apiKey = "a42405df"; //OMDB API key

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
            $movies_sql = "SELECT movie_id, title, imdb_id FROM movies WHERE ";
            $params = [];
            $movies_sql .= "title LIKE :search_value";
            $params[':search_value'] = "%$search_value%";
            $movies_query = $db->prepare($movies_sql);
            $movies_query->execute($params);

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


        <?php if (!empty($input)) { ?>

            <h3>Users</h3>
            <?php if ($query->rowCount() == 0) { ?>
                <p>No results found</p>
            <?php } else { 
                while($users = $query->fetch()) { ?>
                    <a style="text-decoration:none;" href="public_profile.php?search_value=<?php echo $users['username']; ?>&user_id=<?php echo $users['user_id']; ?>">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <img src="avatars/avatar<?php echo $users['user_id']; ?>.jpg" class="rounded-circle" width="45" height="45" alt="Avatar">
                                        &nbsp;
                                        <?php echo $users['username'];?><br/>
                                    </h5>
                                </div>
                            </div>
                        </div> 
                    </a>
                <?php } 
            } $query->closeCursor(); ?>

            <br/>


            <h3>Lists</h3>           
            <?php if ($lists_query->rowCount() == 0) { ?>
                <p>No results found</p>
            <?php } else { 
                while($lists = $lists_query->fetch()) { ?>
                    <a style="text-decoration:none;" href="open_list.php?list_id=<?php echo $lists['list_id'];?>">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $lists['title'] ?></h5>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php }
            }
            
            $lists_query->closeCursor(); ?>

            <br/>

            <h3>Movies</h3>            
            <?php if ($movies_query->rowCount() == 0) { ?>
                <p>No results found</p>
            <?php } else { 
                while($movies = $movies_query->fetch()) { ?>
                    <a href="movie_page.php?search_value=<?php echo $movies['title']; ?>&movie_id=<?php echo $movies['movie_id']; ?>">
                        <?php $url = "http://www.omdbapi.com/?apikey=" . $apiKey . "&i=" . $movies['imdb_id'];
                        $response = file_get_contents($url);
                        $movie_data = json_decode($response, true); ?>
                        <div class="poster-grid">
                            <?php if (!empty($movie_data['Poster'])) { ?>
                                <img src="<?php echo $movie_data['Poster'];?>" class="mini-poster poster-img" alt="<?php echo $movie_data['Title'];?>">
                            <?php } ?>
                        </div>
                    </a>
                <?php } 
            }
            $movies_query->closeCursor();
            $db = null;

        } else { ?>
            <p>No results found</p>
        <?php } ?>
        
    </div>
    
</main>

<?php require('footer.php'); ?>