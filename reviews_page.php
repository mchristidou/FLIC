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
        <h1>Movie Reviews</h1>
    </div>
    
    <span class="border">
        <div class="container">
            <div class="row">
                <div class="col">
                    <!--empty-->
                </div>
                <div class="col-6">

                    <h2>My Reviews</h2>

                    <?php echo_msg() ?>

                    <button name="submit" type="submit" id="submit" class="btn btn-dark" 
                    data-bs-toggle="modal" data-bs-target="#reviewmovie" >+ New Review</button></br>

                    <hr>

                    <div class="modal fade" id="reviewmovie" tabindex="-1" aria-labelledby="reviewmovieLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add your review</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="add_review.php" method="get">
                                        <select class="form-select mb-2" id="movie_id" name="movie_id">
                                            <option value="-1" selected="selected">Select Movie</option>
                                            <?php $sql = "SELECT movie_id, title FROM movies;";
                                            $query = $db->prepare($sql);
                                            $query->execute(); 
                                            while ($result = $query->fetch()) { ?> 
                                            <option value="<?php echo $result['movie_id'] ?>">
                                                <?php echo $result['title']; ?>
                                            </option>
                                            <?php } $query->closeCursor(); ?>
                                        </select>
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
                                </div>
                                <div class="modal-footer">
                                            <button type="submit" class="btn btn-dark">Add</button>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $user_id = $_SESSION['user_id'];
                    $sql = "SELECT review_id, user_id, title, reviews.rating, review_text, movies.movie_id as id 
                    FROM reviews JOIN movies ON reviews.movie_id = movies.movie_id WHERE user_id = :user_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id)); 
                    while ($record = $query->fetch()) { ?>
                    <form action="delete_review.php" method="get">
                        <?php $user = $record['user_id'];
                        $review_id = $record['review_id'];
                        $sql2 = "SELECT username FROM users WHERE user_id = :user";
                        $query2 = $db->prepare($sql2);
                        $query2->execute(array(':user'=>$user));
                        $result = $query2->fetch() ?>
                        <div class="card w-100 mb-3">
                            <div class="card-body">
                                <div class="dropdown">
                                    <button class="btn" type="button" style="float:right;" data-bs-toggle="dropdown" aria-expanded="false">
                                        ...
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item" type="button"
                                        data-bs-target="#editReview_<?php echo $record['review_id']; ?>" data-bs-toggle="modal">Edit</button></li> <!-- error -->
                                        <li><button class="dropdown-item" type="submit" name="submit" value="del">Delete</button></li>
                                    </ul>
                                </div>

                                <h5 class="card-title">
                                    <a href="movie_page.php?movie_id=<?php echo $record['id']; ?>" style="float:left;"><?php
                                        echo $record['title'];
                                    ?></a><br/>
                                </h5>
                                <p><?php echo $result['username']; ?></p>
                                <input type="hidden" name="review_id" id="review_id" value="<?php echo $record['review_id']; ?>"> <!--passing info to php file -->
                                <p class="card-text">
                                    <!-- STAR RATING -->
                                    <div class="star-rating-readonly" data-rating="<?php echo $record['rating']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                    </div>

                                    <br/>

                                    <!-- Displaying the review text -->
                                    <?php //echo 'Rating:'.$record['rating'].'/5'.'<br/>'; ?>

                                    <?php echo $record['review_text'];

                                    //LIKE BUTTON 
                                    $sql3 = "SELECT count(*) AS exist FROM review_likes WHERE user_id = :user_id AND review_id = :review_id";
                                    $query3 = $db->prepare($sql3);
                                    $query3->execute(array(':user_id'=>$user_id, ':review_id'=>$review_id)); 
                                    $res = $query3->fetch(); 
                                    if ($res['exist'] == 0) { ?>
                                        <a class="btn" id="like" type="button" style="float:right;" href="like_review?review_id=<?php echo $record['review_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                            </svg>
                                        </a>
                                    <?php } else if ($res['exist'] == 1) { ?>
                                        <a class="btn" id="unlike" type="button" style="float:right;" href="like_review?review_id=<?php echo $record['review_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                            </svg>
                                        </a>
                                    <?php } ?>

                                    <!--COMMENT BUTTON -->
                                    <a class="btn" id="comment" type="button" style="float:right;" href="open_review.php?review_id=<?php echo $record['review_id']; ?>&creator=<?php echo $result['username']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                        </svg>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>

                    <!--Dynamic Modal ID -->
                    <div class="modal fade" id="editReview_<?php echo $record['review_id']; ?>" tabindex="-1" aria-labelledby="editReviewLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editReviewLabel">Edit review</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="update_review.php" method="get">
                                       <!-- STAR RATING -->
                                        <div class="star-rating mb-3">
                                            <input type="radio" id="star1_<?php echo $record['review_id'];?>" name="edit_rating" value="1">
                                            <label for="star1_<?php echo $record['review_id'];?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                            </label>
                                            <input type="radio" id="star2_<?php echo $record['review_id'];?>" name="edit_rating" value="2">
                                            <label for="star2_<?php echo $record['review_id'];?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                            </label>
                                            <input type="radio" id="star3_<?php echo $record['review_id'];?>" name="edit_rating" value="3">
                                            <label for="star3_<?php echo $record['review_id'];?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                            </label>
                                            <input type="radio" id="star4_<?php echo $record['review_id'];?>" name="edit_rating" value="4">
                                            <label for="star4_<?php echo $record['review_id'];?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                            </label>
                                            <input type="radio" id="star5_<?php echo $record['review_id'];?>" name="edit_rating" value="5">
                                            <label for="star5_<?php echo $record['review_id'];?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <textarea name="review_text" id="review_text" class="form-control" rows="10" placeholder="Write your review here..."><?php echo $record['review_text']; ?></textarea>
                                        <input type="hidden" name="review_id" id="review_id" value="<?php echo $record['review_id']; ?>">
                                </div>
                                <div class="modal-footer">
                                        <button type="submit" name="submit" value="edit" class="btn btn-dark">Apply</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }
                    if ($query->rowCount() == 0) { ?>
                        <p>No reviews added yet!</p>
                    <?php }
                    $query->closeCursor(); ?>
                </div>
                <div class="col">
                    <h2>Friend Reviews</h2>

                    <hr>

                    <?php $sql = "SELECT review_id, user_id, title, reviews.rating, review_text, movies.movie_id as id 
                    FROM reviews JOIN movies ON reviews.movie_id = movies.movie_id where user_id != :user_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id));
                    while($record = $query->fetch()) { ?>
                        <?php $user = $record['user_id']; 
                        $review = $record['review_id'];
                        $sql2 = "SELECT username FROM users WHERE user_id = :user";
                        $query2 = $db->prepare($sql2);
                        $query2->execute(array(':user'=>$user));
                        $result = $query2->fetch() ?>
                        <div class="card w-100 mb-3 mt-4">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="movie_page.php?movie_id=<?php echo $record['id']; ?>" style="float:left;"><?php
                                        echo $record['title']; 
                                    ?></a><br/>
                                </h5>
                                <p><?php echo $result['username']; ?></p>
                                <input type="hidden" name="review_id" id="review_id" value="<?php echo $record['review_id']; ?>"> <!--passing info to php file -->
                                <p class="card-text">
                                    <!-- STAR RATING -->
                                    <div class="star-rating-readonly" data-rating="<?php echo $record['rating']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                    </div>

                                    <br/>

                                    <?php echo $record['review_text']; ?>

                                    <?php $sql3 = "SELECT count(*) AS exist FROM review_likes WHERE user_id = :user_id AND review_id = :review_id";
                                    $query3 = $db->prepare($sql3);
                                    $query3->execute(array(':user_id'=>$user_id, ':review_id'=>$review)); 
                                    $res = $query3->fetch(); 
                                    if ($res['exist'] == 0) { ?>
                                        <a class="btn" id="like" type="button" style="float:right;" href="like_review?review_id=<?php echo $record['review_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                            </svg>
                                        </a>
                                    <?php } else if ($res['exist'] == 1) { ?>
                                        <a class="btn" id="unlike" type="button" style="float:right;" href="like_review?review_id=<?php echo $record['review_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                            </svg>
                                        </a>
                                    <?php } ?>

                                    <!--COMMENT BUTTON-->
                                    <a class="btn" id="comment" type="button" style="float:right;" href="open_review.php?review_id=<?php echo $record['review_id']; ?>&creator=<?php echo $result['username']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                        </svg>
                                    </a>
                                </p>
                            </div>
                        </div>
                    <?php } $query->closeCursor();
                    $query2->closeCursor();
                    $query3->closeCursor();
                    $db = null; ?>
                </div> 
            </div>
        </div>
    </span>
</main>

<script>
    document.querySelectorAll('.star-rating:not(.readonly) label').forEach(star => {
        star.addEventListener('click', function() {
            this.style.transform = 'scale(1.2)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    });
</script>

<?php require('footer.php'); ?>

