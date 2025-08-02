<?php 
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

?>

<main id="main" class="flex-grow-1">
    <div class="container container-expand-sm text-center bg-secondary-subtle shadow rounded-5" style="margin-top:10px; padding:15px; width:200;">
        <h1>Movies</h1>
    </div>

    <?php echo_msg(); ?>
    
    <?php $fave_genre = $_SESSION['fave_genre'];
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users JOIN genres WHERE genres_id= :fave_genre AND user_id = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(':user_id' => $user_id, ':fave_genre' => $fave_genre));
    $result = $query->fetch();
    $genre = $result['name']; ?>

    <!-- Movies you might like -->
    <div style="margin:20px 20px">
        <h3>Movies you might like...</h3>

        <?php $sql = "SELECT * FROM movies WHERE genre = :genre";
        $query = $db->prepare($sql);
        $query->execute(array(':genre'=>$genre)); ?>
        <div class="row row-cols-1 row-cols-md-4 g-4"> <!--FIX SIZE, MAKE RESPONSIVE -->
            <?php while ($record = $query->fetch()) { ?>
                <a href="movie_page.php?movie_id=<?php echo $record['movie_id']; ?>">
                    <div class="col">
                        <div class="card">
                            <?php $sql2 = "SELECT path FROM movie_posters WHERE movie_id = :movie_id";
                            $query2 = $db->prepare($sql2);
                            $query2->execute(array(':movie_id'=>$record['movie_id']));
                            $results = $query2->fetch(); ?>
                            <?php if (!empty($results['path'])) { ?>
                                <img src="<?php echo $results['path'];?>" class="card-img-top" alt="...">
                            <?php } ?>
                            <div class="card-body">
                                    <h5 class="card-title"><?php echo $record['title'] ?></h5>
                                    <p class="card-text">Genre: <?php echo $record['genre'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php $query2->closeCursor(); ?>
                </a>    
            <?php } ?>
            <?php $query->closeCursor(); ?>
        </div>
    </div>

    <div id="other-movies-section">
       <!-- Other movies -->
        <div style="margin:20px 20px">
        <h3>Other movies...</h3>

        <div class="row row-cols-1 row-cols-md-4 g-4"> <!--FIX SIZE, MAKE RESPONSIVE -->
            <?php while ($record = $query->fetch()) { ?>
                <a href="movie_page.php?movie_id=<?php echo $record['movie_id']; ?>">
                    <div class="col">
                        <div class="card">
                            <?php $poster_sql = "SELECT path FROM movie_posters WHERE movie_id = :movie_id";
                            $poster_query = $db->prepare($poster_sql);
                            $poster_query->execute(array(':movie_id'=>$record['movie_id']));
                            $results = $poster_query->fetch(); ?>
                            <?php if (!empty($results['path'])) { ?>
                                <img src="<?php echo $results['path'];?>" class="card-img-top" alt="...">
                            <?php } $poster_query->closeCursor(); ?>
                            <div class="card-body">
                                    <h5 class="card-title"><?php echo $record['title'] ?></h5>
                                    <p class="card-text">Genre: <?php echo $record['genre'] ?></p>
                            </div>
                        </div>
                    </div>
                </a>  
            <?php } ?>
        </div> 

        <nav aria-label="Film pagination" style="margin-top:10px;">
            <ul class="nav justify-content-center pagination pagination-sm">
                <?php if ($page <= 1) { ?> <!-- Previous button -->
                    <li class="page-item disabled">
                        <a class="page-link" href="" tabindex="-1" aria-disabled="true" aria-label="Previous"><span aria-hidden="true">&laquo</span></a>
                    </li>
                <?php } else { ?> 
                    <li class="page-item">
                        <a class="page-link text-dark" href="" role="button" data-page="<?php echo ($page-1); ?>" aria-label="Previous"><span aria-hidden="true">&laquo</span></a>
                    </li>
                <?php } ?>

                <?php 
                    for ($i=1; $i<=$num_of_pages; $i++) {
                        if ($page == $i) {
                            echo '<li class="page-item active"><a class="page-link bg-dark active" style="border-color:black;" data-page="'.$i.'" href="">'.$i.'</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link text-dark" data-page="'.$i.'" href="">'.$i.'</a></li>';
                        }
                    }
                ?>

                <?php if ($page >= $num_of_pages) { ?> <!-- Next button -->
                    <li class="page-item disabled">
                        <a class="page-link" href="" tabindex="-1" aria-disabled="true" aria-label="Next"><span aria-hidden="true">&raquo</span></a>
                    </li>
                <?php } else { ?>
                    <li class="page-item">
                        <a class="page-link text-dark" href="" data-page="<?php echo ($page+1); ?>" role="button" aria-label="Next"><span aria-hidden="true">&raquo</span></a>
                    </li>
                <?php } ?>
                </ul>
            </nav>
        </div>
    </div>

    <?php $db = null; ?>

</main>

<?php require('footer.php'); ?>
