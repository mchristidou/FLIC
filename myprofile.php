<?php 
    session_start();

    require('db_conn.php');

    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $avatar = $_SESSION['avatar'];

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
        
        <div class="modal fade" id="chooseAvatar" tabindex="-1" aria-labelledby="chooseAvatarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h1 class="modal-title fs-5" id="chooseAvatarLabel">Choose your Avatar</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <form action="choose_avatar.php" method="post"> <!--CHOOSE AVATAR-->
                                    <input type="hidden" name="selectedAvatar" id="selectedAvatar">
                                    <div class="row row-cols-2 row-cols-md-4 g-3 p-3 align-items-center">
                                        <div class="input-group">
                                            <div class="col-6 col-md-3 mb-3">
                                                <img src="avatars/avatar1.jpg" onclick="return selected(this);" class="avatarpic rounded-circle" style="width:100px; height:100px;" alt="avatar1.jpg">
                                            </div>
                                            <div class="col-6 col-md-3 mb-3">
                                                <img src="avatars/avatar2.jpg" onclick="return selected(this);" class="avatarpic rounded-pill" style="width:100px; height:100px;" alt="avatar2.jpg">
                                            </div>
                                            <div class="col-6 col-md-3 mb-3">
                                                <img src="avatars/avatar3.jpg" onclick="return selected(this);" class="avatarpic rounded-pill" style="width:100px; height:100px;" alt="avatar3.jpg">
                                            </div>
                                            <div class="col-6 col-md-3 mb-3">
                                                <img src="avatars/avatar4.jpg" onclick="return selected(this);" class="avatarpic rounded-pill" style="width:100px; height:100px;" alt="avatar4.jpg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <div class="modal-footer">
                                    <button type="submit" class="btn btn-dark">Choose</button>
                                </form>
                        </div>
                    </div>
            </div>
        </div>
        
        <h1>
            <?php echo $username; ?>
            <button name="submit" type="submit" id="submit" class="btn btn-sm" 
            data-bs-toggle="modal" data-bs-target="#editUsername"> <!--EDIT BUTTON-->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                </svg>
            </button>
        </h1>

        <div class="modal fade" id="editUsername" tabindex="-1" aria-labelledby="editUsernameLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editUsernameLabel">Choose your new username</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <form action="edit_username.php" method="post" onsubmit="return validate_newUsername();">
                                    <div class="row g-3 align-items-center">
                                        <div class="input-group mb-3 col-sm-12">
                                            <input type="text" name="newUsername" id="newUsername" class="input-group form-control" placeholder="Username" aria-describedby="inputGroup-sizing-default" size="25" maxlength="25" />
                                            <span class="input-group-text" id="inputGroup-sizing-default">(8-15 characters)</span>
                                        </div>
                                    </div>
                                </div>
                        <div class="modal-footer">
                                    <button type="submit" class="btn btn-dark">Submit</button>
                                </form>
                        </div>
                    </div>
            </div>
        </div>

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
                <p style="margin:0; font-weight: bold;"><?php echo $followers['Followers']; ?></p>
            </div>
            <div>
                <p style="margin:0;">Following</p>
                <p style="margin:0; font-weight: bold;"><?php echo $following['Following']; ?></p>
            </div>
            <?php $query->closeCursor();
            $query2->closeCursor(); ?>
        </div>

        <?php if($_SESSION['username'] != $username) { ?>
            <button name="follow" type="button" id="follow" class="btn btn-dark">Follow</button>
        <?php } ?>

        <?php echo_msg(); ?>
    </div>

    <div class="row m-1">
        <div class="col">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link text-dark active" data-bs-toggle="tab" href="#mylists">My Lists</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" data-bs-toggle="tab" href="#myreviews">My Reviews</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" data-bs-toggle="tab" href="#myfriends">My Friends</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" data-bs-toggle="tab" href="#mydetails">My Details</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="mylists">
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

                <a class="icon-link icon-link-hover text-dark m-2" style="text-decoration:none;" href="lists_page.php">
                    Add More
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                    </svg>
                </a>
                
            </div>
        </div>

        <div class="tab-pane fade" id="myreviews">
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

                <a class="icon-link icon-link-hover text-dark m-2" style="text-decoration:none;" href="lists_page.php">
                    Add More
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                    </svg>
                </a>

            </div>
        </div>

        <div class="tab-pane fade" id="myfriends">
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
                                                <?php echo $record['username'];?><br/>
                                            </h5>
                                        </div>
                                    </div>
                                </div> 
                            </a>
                        <?php } ?>
                    </div>
                    <div class="text-center">
                        <?php if (!$has_friends) {
                            echo 'No friends found.';
                        } ?>
                    </div> 
                    <?php $query->closeCursor(); ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="mydetails">
            <div class="row m-1 p-10">
                <?php $sql = "SELECT username,email,fave_genre FROM users WHERE user_id = :user_id;";
                $query = $db->prepare($sql);
                $query->execute(array(':user_id'=>$user_id)); 
                $record = $query->fetch(); ?>
                <div class="row row-cols-1 row-cols-md-2 g-2 p-3">
                    <!-- DISPLAY DATA -->
                    <div class="col">
                        <p class="m-2">Username</p>
                        <?php $inputId = 'username'; ?>
                        <form action="edit_username.php" method="post" onsubmit="return validate_username();">
                            <div class="input-group mb-3">
                                <input type="text" id="username" name="username" class="form-control" placeholder="<?php echo $record['username']; ?>" size="25" maxlength="25">
                                <button type="submit" class="btn btn-dark">Change</button>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <p class="m-2">Email</p>
                        <form action="edit_email.php" method="post" onsubmit="return validate_email();">
                            <div class="input-group mb-3">
                                <input type="text" id="email" name="email" class="form-control" placeholder="<?php echo $record['email']; ?>" maxlength="25">
                                <button class="btn btn-dark">Change</button>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <form action="edit_password.php" method="post">
                            <p class="m-2">Password</p>
                            <div class="input-group mb-3">
                                <input type="password" id="password" name="password" autocomplete="off" value="" class="form-control" maxlength="25">
                            </div>
                            <p class="m-2">Confirm Password</p>
                            <div class="input-group mb-3">
                                <input type="password" id="passwordconf" name="passwordconf" autocomplete="off" class="form-control" maxlength="25">
                                <button class="btn btn-dark">Change</button>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <p class="m-2">Favourite Genre</p>
                        <form action="edit_fave_genre.php" method="post">
                            <div class="input-group mb-3">
                                <!--option-->
                                <?php $fave_genre = $record['fave_genre'];
                                $genres = "SELECT name FROM genres WHERE genres_id = :fave_genre";
                                $q = $db->prepare($genres);
                                $q->execute(array(':fave_genre'=>$fave_genre));
                                $fave = $q->fetch(); 
                                $q->closeCursor(); ?>
                                <select class="form-select" id="fave_genre" name="fave_genre">
                                    <option value="-1" selected="selected">-- <?php echo $fave['name']; ?> --</option>
                                    <?php $genres = "SELECT genres_id, name FROM genres";
                                    $q = $db->prepare($genres);
                                    $q->execute(); 
                                    while ($result = $q->fetch()) { ?> 
                                        <option value="<?php echo $result['genres_id'] ?>">
                                            <?php echo $result['name']; ?>
                                        </option>
                                    <?php } $q->closeCursor(); ?>
                                </select>
                                <button class="btn btn-dark">Change</button>
                            </div>
                        </form>
                    </div>
                    <?php $query->closeCursor();
                    $db = null; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require('footer.php'); ?>