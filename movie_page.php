<?php 
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

    $response = file_get_contents('http://www.omdbapi.com/?apikey=a42405df&i=tt1856101'); // Example movie ID - Blade Runner 2049
    $movie_data = json_decode($response, true);
    
?>

<main id="main" class="flex-grow-1">
    <div class="container" style="margin-top:10px; padding:15px; display: flex; align-items: flex-start;">
        <div class="row">
            <div class="col-16">

                <div class="col-4">
                    <img src="movie_posters/bladerunner_mp.jpg" class="poster img-fluid float-md-start me-md-3 mb-3 rounded shadow" 
                    alt="Movie Poster">
                </div>
            
                <?php $movie_id = $_GET['movie_id'];
                $sql = "SELECT * FROM movies WHERE movie_id = :movie_id";
                $query = $db->prepare($sql);
                $query->execute(array(':movie_id'=>$movie_id));
                $record = $query->fetch(); ?>

                <div>
                    <h1>
                        <?php echo $record['title']; ?>
                        <div style="float:right;font-size:large;">
                            <span><strong>IMDB RATING</strong></span>
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                                <span class="mb-0"><?php echo $movie_data['imdbRating']; ?>/10</span>
                            </div>
                        </div>
                    </h1>

                    <p><?php echo $movie_data['Year']." - ".$movie_data['Runtime']." - ".$record['genre']; ?></p>
                    <!--genre matches the genre in the database-->
                </div>
                <p><?php echo $movie_data['Plot']; ?></p>
                <?php echo_msg() ?> 
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
                                    <!-- STAR RATING -->
                                    <div class="star-rating mb-3">
                                        <input type="radio" id="star1" name="rating" value="1">
                                        <label for="star1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                        </label>
                                        <input type="radio" id="star2" name="rating" value="2">
                                        <label for="star2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                        </label>
                                        <input type="radio" id="star3" name="rating" value="3">
                                        <label for="star3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                        </label>
                                        <input type="radio" id="star4" name="rating" value="4">
                                        <label for="star4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                        </label>
                                        <input type="radio" id="star5" name="rating" value="5">
                                        <label for="star5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                        </label>
                                    </div>
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

                <hr/>
                <p><strong>Director:&nbsp;</strong><?php echo $movie_data['Director']; ?></p>
                <hr/>
                <p><strong>Writers:&nbsp</strong><?php echo $movie_data['Writer']; ?></p>
                <hr/>
                <p><strong>Stars:&nbsp</strong><?php echo $movie_data['Actors']; ?></p>
                <hr/>

                <h3 class="mb-3">More Info</h3>
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm p-2 h-100">
                            <div class="card-body">
                                <h5 class="card-title">Box Office</h5>
                                <p class="card-text text-success"><?php echo $movie_data['BoxOffice']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm p-2 h-100">
                            <div class="card-body">
                                <h5 class="card-title">Awards</h5>
                                <p class="card-text"><?php echo $movie_data['Awards']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm p-2 h-100">
                            <div class="card-body">
                                <h5 class="card-title">Country</h5>
                                <p class="card-text"><?php echo $movie_data['Country']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm p-2 h-100">
                            <div class="card-body">
                                <h5 class="card-title">Language</h5>
                                <p class="card-text"><?php echo $movie_data['Language']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</main>

<?php require('footer.php'); ?>
