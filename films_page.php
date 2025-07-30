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
        <?php require('other_movies_ajax.php'); ?>
    </div>
    
    <?php $db = null; ?>

</main>

<script>
document.addEventListener('click', function(e) {
    // Only handle clicks on .page-link inside #other-movies-section
    if (
        e.target.classList.contains('page-link') &&
        e.target.closest('#other-movies-section')
    ) {
        e.preventDefault();
        fetch(e.target.href)
            .then(response => response.text())
            .then(html => {
                document.getElementById('other-movies-section').innerHTML = html;
                document.getElementById('other-movies-section').scrollIntoView({behavior: "smooth"});
            });
    }
});
</script>

<?php require('footer.php'); ?>
