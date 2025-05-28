<?php 
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');
    
?>

<main id="main" class="flex-grow-1">
    <div style="margin:20px 20px">
    
        <?php $movie_id = $_GET['movie_id'];
        $sql = "SELECT * FROM movies WHERE movie_id = :movie_id";
        $query = $db->prepare($sql);
        $query->execute(array(':movie_id'=>$movie_id));
        $record = $query->fetch(); ?>
        <h1><?php echo $record['title']; ?></h1>
        <!--<img src="" alt="...">-->
        <?php echo_msg() ?>
        <h2><?php echo $record['genre']; ?></h2> 
        <p><?php echo $record['description']; ?></p>
        <?php $query->closeCursor(); ?>

        <button name="submit" type="submit" id="submit" class="btn btn-dark" 
        data-bs-toggle="modal" data-bs-target="#addmovie" >Add to list</button>

        <div class="modal fade" id="addmovie" tabindex="-1" aria-labelledby="addmovieLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Select list</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php $user_id = $_SESSION['user_id'];
                        $sql2 = "SELECT list_id, title FROM lists WHERE user_id = :user_id";
                        $query2 = $db->prepare($sql2);
                        $query2->execute(array(':user_id'=>$user_id));
                        while ($result = $query2->fetch()) { ?>
                            <form action="add_to_list.php" method="get">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="list_id" value="<?php echo $result['list_id']; ?>" id="flexCheckList_<?php echo $result['list_id']; ?>">
                                    <label class="form-check-label" for="flexCheckList_<?php echo $result['list_id']; ?>">
                                        <p><?php echo $result['title']; ?></p>
                                    </label>
                                </div>
                                <input type="hidden" id="movie_id" name="movie_id" value="<?php echo $record['movie_id']; ?>">
                        <?php }
                        $query->closeCursor();
                        $db = null; ?>
                    </div>
                    <div class="modal-footer">
                                <button type="submit" class="btn btn-dark">Add</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>

        <button name="submit" type="submit" id="submit" class="btn btn-dark" 
        data-bs-toggle="modal" data-bs-target="#reviewmovie" >Review</button>

        <div class="modal fade" id="reviewmovie" tabindex="-1" aria-labelledby="reviewmovieLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add your review</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="add_review.php" method="get">
                            <select class="form-select mb-3" id="rating" name="rating">
                                <option value="-1" selected="selected">Rating</option> 
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <textarea name="review_text" id="review_text" class="form-control" rows="10" placeholder="Write your review here..."></textarea>
                            <input type="hidden" id="movie_id" name="movie_id" value="<?php echo $movie_id; ?>">
                    </div>
                    <div class="modal-footer">
                                <button type="submit" class="btn btn-dark">Add</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php require('footer.php'); ?>
