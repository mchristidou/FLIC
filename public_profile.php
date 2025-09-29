<?php 
    session_start();

    require('db_conn.php');
    
    $current_user = $_SESSION['user_id']; //user_id of the currently logged in user
    $search_value = $_GET['search_value'];
    $user_id = $_GET['user_id']; //user_id of the profile being viewed
    
    //get username and avatar of the profile being viewed
    $sql = "SELECT username, avatar FROM users WHERE user_id = :id;";
    $query = $db->prepare($sql);
    $query->execute(array(':id'=>$user_id));
    $res = $query->fetch();
    $username = $res['username'];
    $avatar = $res['avatar'];
    $query->closeCursor();

    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');
?>

<main id="main" class="flex-grow-1">
    <div class="container container-expand-sm text-center" style="margin-top:50px; padding:15px; width:200;">

        <?php if (!isset($avatar)) { ?>
            <img src="profile.jpg" id="avatar" class="rounded-pill" style="width:100px; height:100px;" alt="Avatar" data-bs-toggle="modal" data-bs-target="#chooseAvatar">
        <?php } else { ?>
            <img src="avatars/<?php echo $avatar; ?>" id="avatar" class="rounded-pill" style="width:100px; height:100px;" alt="Avatar" data-bs-toggle="modal" data-bs-target="#chooseAvatar">
        <?php } ?> 

        <h1><?php echo $search_value; ?></h1>

        <?php $sql = "SELECT count(user_id2) AS Following FROM friends WHERE user_id1 = :user_id;";
        $query = $db->prepare($sql);
        $query->execute(array(':user_id'=>$user_id));
        $following = $query->fetch(); ?>

        <?php $sql2 = "SELECT count(user_id1) AS Followers FROM friends WHERE user_id2 = :user_id;";
        $query2 = $db->prepare($sql2);
        $query2->execute(array(':user_id'=>$user_id)); 
        $followers = $query2->fetch(); ?>

        <div class="d-flex justify-content-center gap-3">
            <div>
                <p style="margin:0;">Followers</p>
                <p style="margin:0; font-weight: bold;"><?php echo $followers['Followers']; ?></p> <!-- echo followers result -->
            </div>
            <div>
                <p style="margin:0;">Following</p>
                <p style="margin:0; font-weight: bold;"><?php echo $following['Following']; ?></p> <!-- echo following result -->
            </div>
            <?php $query->closeCursor();
            $query2->closeCursor(); ?>
        </div>

        <?php $sql = "SELECT * FROM friends WHERE user_id1 = :user_id AND user_id2 = :p_user";
        $query = $db->prepare($sql);
        $query->execute(array(':user_id'=>$current_user, ':p_user'=>$user_id)); 
        $result = $query->rowCount(); ?>

        <?php if ($current_user != $user_id) { ?> <!--if the profile is the current user, don't show follow button-->
            <?php if(($_SESSION['username'] != $search_value || !isset($_SESSION['username'])) && $result == 0) { ?>
                <a href="follow.php?user_id=<?php echo $user_id;?>&action=follow" name="follow" type="button" id="follow" class="btn m-2 btn-dark">Follow</a>
            <?php } else { ?>
                <a href="follow.php?user_id=<?php echo $user_id;?>&action=unfollow" type="button" id="unfollow" name="unfollow" class="btn m-2 btn-dark">Unfollow</a>
            <?php } $query->closeCursor();
        } ?>
        <?php echo_msg(); ?>

    </div>

    <div class="row m-1 p-10">
        <div class="col">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link text-dark active" data-toggle="tab" href="#lists">Lists</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" data-toggle="tab" href="#reviews">Reviews</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" data-toggle="tab" href="#friends">Friends</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="lists">
            <!-- Display lists made by the user -->
            <div class="row m-1 p-10">
                <h4 class="ms-3 mt-3 p-1">Made by me</h4>

                <div style="overflow-y: auto; max-height: 160px;">
                    <?php $sql = "SELECT * FROM lists WHERE user_id = :user_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id)); 
                    $has_lists = false; ?>
                    <div class="row row-cols-1 row-cols-md-4 g-2 p-3">
                        <?php while ($record = $query->fetch()) { 
                            $has_lists = true; ?>
                            <a style="text-decoration:none;" href="open_list.php?list_id=<?php echo $record['list_id'];?>">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $record['title'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div> 
                </div>
                
                <div class="ms-1 text-center">
                    <?php if (!$has_lists) {
                        echo 'No liked lists found.';
                    } ?>
                </div>
                <?php $query->closeCursor(); ?>

            </div>

            <hr>

            <!-- Display lists liked by the user -->
            <div class="row m-1 p-10">
                <h4 class="ms-3 mt-3 p-1">Liked</h4>

                <div style="overflow-y: auto; max-height: 160px;">
                    <?php $sql = "SELECT list_likes.list_id, list_likes.user_id, lists.user_id as creator, title 
                    FROM list_likes 
                    JOIN lists 
                    ON lists.list_id = list_likes.list_id 
                    WHERE list_likes.user_id = :user_id AND list_likes.user_id != lists.user_id;";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id)); 
                    $has_lists = false; ?>
                    <div class="row row-cols-1 row-cols-md-4 g-2 p-3">
                        <?php while ($record = $query->fetch()) { 
                            $has_lists = true; ?>
                            <a style="text-decoration:none;" href="open_list.php?list_id=<?php echo $record['list_id'];?>">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $record['title'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </a>    
                        <?php } ?>
                    </div>
                </div>

                <div class="ms-1 text-center">
                    <?php if (!$has_lists) {
                        echo 'No liked lists found.';
                    } ?>
                </div>
                <?php $query->closeCursor(); ?>
                
            </div>
        </div>

        <div class="tab-pane fade" id="reviews">
            <!-- Display reviews made by the user -->
            <div class="row m-1 p-10">
                <h4 class="ms-3 mt-3 p-1">Made by me</h4>

                <div style="overflow-y: auto; max-height: 160px;">
                    <?php $sql = "SELECT review_id, user_id, title, reviews.rating, review_text, movies.movie_id as id 
                    FROM reviews JOIN movies ON reviews.movie_id = movies.movie_id WHERE user_id = :user_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id));
                    $has_reviews = false; ?>
                    <div class="row row-cols-1 row-cols-md-4 g-2 p-3">
                        <?php while ($record = $query->fetch()) { 
                            $has_reviews = true; ?>
                            <a style="text-decoration:none;" href="open_review.php?review_id=<?php echo $record['review_id'];?>&creator=<?php echo $username; ?>">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?php echo $record['title'];?><br/>
                                            </h5>
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
                                                
                                                <div class="review_text mt-1">
                                                    <?php if ($record['review_text']) {
                                                        echo $record['review_text'];
                                                    } else {
                                                        echo 'No review text provided.';
                                                    } ?>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                </div> 
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="ms-1 text-center">
                    <?php if (!$has_reviews) {
                        echo 'No reviews found.';
                    } ?>
                </div>
                <?php $query->closeCursor(); ?>
            </div>

            <hr> 

            <!-- Display reviews liked by the user -->
            <div class="row m-1 p-10">
                <h4 class="ms-3 mt-3 p-1">Liked</h4>

                <div style="overflow-y: auto; max-height: 160px;">
                    <?php $sql = "SELECT review_likes.review_id, review_likes.user_id, reviews.user_id as creator,
                    reviews.movie_id, reviews.rating, reviews.review_text, title
                    FROM review_likes 
                    JOIN reviews 
                    ON reviews.review_id = review_likes.review_id JOIN movies 
                    ON reviews.movie_id = movies.movie_id
                    WHERE review_likes.user_id = :user_id AND review_likes.user_id != reviews.user_id;";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id)); 
                    $has_reviews = false; ?>
                    <div class="row row-cols-1 row-cols-md-4 g-2 p-3">
                        <?php while ($record = $query->fetch()) {
                            $has_reviews = true; ?>
                            <a style="text-decoration:none;" href="open_review.php?review_id=<?php echo $record['review_id'];?>&creator=<?php echo $username; ?>">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?php echo $record['title'];?><br/>
                                            </h5>
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
                                                
                                                <div class="review_text mt-1">
                                                    <?php if ($record['review_text']) {
                                                        echo $record['review_text'];
                                                    } else {
                                                        echo 'No review text provided.';
                                                    } ?>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                </div> 
                            </a>
                        <?php } ?> 
                    </div>
                </div>

                <div class="ms-1 text-center">
                    <?php if (!$has_reviews) {
                        echo 'No liked reviews found.';
                    } ?>
                </div>

                <?php $query->closeCursor(); ?>

            </div>
        </div>

        <div class="tab-pane fade" id="friends">
            <!-- Display friends of the user -->
            <div class="row m-1 p-10">
                <div style="overflow-y: auto;">
                    <?php $sql = "SELECT user_id, username, avatar FROM users JOIN friends ON user_id=user_id2 WHERE user_id1 = :user_id;";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id)); 
                    $has_friends = false; ?>
                    <div class="row row-cols-1 row-cols-md-4 g-2 p-3">
                        <?php while ($record = $query->fetch()) {
                            $has_friends = true; ?>
                            <a style="text-decoration:none;" href="public_profile.php?search_value=<?php echo $record['username']; ?>&user_id=<?php echo $record['user_id']; ?>">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?php if (isset($record['avatar'])) { ?>
                                                    <img src="avatars/<?php echo $record['avatar']; ?>" class="rounded-circle" width="45" height="45" alt="Avatar">
                                                <?php } else { ?>
                                                    <img src="profile.jpg" class="rounded-circle" width="45" height="45" alt="Avatar">
                                                <?php } ?>
                                                &nbsp;
                                                <?php echo $record['username'];?><br/>
                                            </h5>
                                        </div>
                                    </div>
                                </div> 
                            </a>
                        <?php } $query->closeCursor(); ?>
                    </div>
                    
                    <div class="ms-1 text-center">
                        <?php if (!$has_friends) {
                            echo 'No friends found.';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        /*open navtabs*/
        $(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
        });
    </script>

</main>

<?php require('footer.php'); ?>