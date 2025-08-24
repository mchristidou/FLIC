<?php 
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";
    $user_id = $_SESSION['user_id'];
    $creator = $_GET['creator'];
    $review_id = $_GET['review_id'];

    require('header.php');
    require('nav.php');
    require('functions.php');

?>

<main id="main" class="flex-grow-1">
    <span class="border">
        <div class="container">
            <div class="row">
                <div class="col-8 m-4">
                    <?php $sql = "SELECT review_id, user_id, title, reviews.rating, review_text, movies.movie_id as id 
                    FROM reviews JOIN movies ON reviews.movie_id = movies.movie_id WHERE review_id=:review_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':review_id'=>$review_id));
                    $record = $query->fetch(); ?>
                    <h1><?php echo 'Movie: '.$record['title']; ?></h1>
                    <p><small><?php echo 'Reviewed by: '.$creator; ?></small></p>
                    <!-- STAR RATING -->
                    <div class="star-rating-readonly" data-rating="<?php echo $record['rating']; ?>">
                        <h5>Rating:</h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                    </div>
                    <br/>
                    <?php if ($record['review_text'] == null) {
                        echo '<p style="text-align: center;">No review text!</p>';
                    } else {
                        echo '<br/>'.$record['review_text'].'<br/>';
                    } $query->closeCursor(); ?>

                    <br/>

                    <!--LIKE BUTTON-->
                    <?php $sql = "SELECT count(*) AS exist FROM review_likes WHERE user_id = :user_id AND review_id = :review_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id, ':review_id'=>$review_id)); 
                    $res = $query->fetch(); 
                    if ($res['exist'] == 0) { ?>
                        <a class="btn d-flex align-items-center mt-1 p-0 gap-2" id="like" type="button" href="like_review?review_id=<?php echo $record['review_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                            </svg>
                            <span>Like</span>
                        </a>
                    <?php } else if ($res['exist'] == 1) { ?>
                        <a class="btn d-flex align-items-center mt-1 p-0 gap-2" id="unlike" type="button" href="like_review?review_id=<?php echo $record['review_id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                            </svg>
                            <span>Unlike</span>
                        </a>
                    <?php } $query->closeCursor(); ?>

                    <hr>

                    <div class="row p-1">
                        <h3>Comments</h3>
                        <!--DB COMMENTS-->
                        <?php $sql = "SELECT * FROM review_comments 
                        JOIN users ON review_comments.user_id = users.user_id
                        WHERE review_id=:review_id";
                        $query = $db->prepare($sql);
                        $query->execute(array(':review_id'=>$review_id));
                        $comments = $query->fetchAll();

                        if ($comments && count($comments) > 0) { //if comments exist and are more than 0
                            foreach ($comments as $output) {
                                echo '<small>' . $output['username'] . '<p style="margin:0; float:right;">' .$output['created_at'].'</p></small>';
                                echo '<p>' . $output['comment']; ?>
                                <!--DELETE BUTTON-->
                                <a href="delete_comment.php?user_id=<?php echo $user_id; ?>&review_id=<?php echo $output['review_id']; ?>&comment_id=<?php echo $output['comment_id']; ?>" class="btn btn-sm" type="button" style="float:right;"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </p>
                            <?php }
                        } else {
                            echo '<p style="text-align: center;">No comments yet!</p>';
                        } $query->closeCursor();  ?>
                        
                        <form id="comment_area" action="comment_review.php?review_id=<?php echo $review_id; ?>" method="post">
                            <div class="mt-3">
                                <label for="comment" class="form-label">Add a comment</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                <button class="btn btn-dark mt-3" type="submit">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col m-4">
                    <!--empty-->
                    <h2>More Reviews</h2>

                    <hr>

                    <?php $sql = "SELECT review_id, user_id, title, reviews.rating, review_text, movies.movie_id as id 
                    FROM reviews JOIN movies ON reviews.movie_id = movies.movie_id where user_id != :user_id AND review_id != :review_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id, ':review_id'=>$review_id));
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
                                    <a href="movie_page.php?movie_id=<?php echo $record['id']; ?>" class="text-dark" style="float:left;text-decoration:none;"><?php
                                        echo $record['title']; 
                                    ?></a><br/>
                                </h5>
                                <?php echo $result['username']; ?>
                                <input type="hidden" name="review_id" id="review_id" value="<?php echo $record['review_id']; ?>"> <!--passing info to php file -->
                                <p class="card-text m-1">
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
                                    
                                    <div class="review_text"> 
                                        <?php if ($record['review_text']) {
                                            echo $record['review_text'];
                                        } else {
                                            echo 'No review text provided.';
                                        } ?>
                                    </div>

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
                        <?php } if ($query->rowCount() == 0) { ?>
                            <p class="text-center">No other friend reviews found!</p>
                        <?php } $query->closeCursor();
                    if (isset($query2)) $query2->closeCursor();
                    if (isset($query3)) $query3->closeCursor();
                    $db = null; ?>
                </div>
            </div>
        </div>
    </span>
</main>

