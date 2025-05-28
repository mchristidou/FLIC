<?php 
    session_start();

    require('db_conn.php');
    
    $current_user = $_SESSION['user_id'];
    $search_value = $_GET['search_value'];
    $user_id = $_GET['user_id'];

    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');
?>

<main id="main" class="flex-grow-1">
    <div class="container container-expand-sm text-center" style="margin-top:50px; padding:15px; width:200;">
        <img src="profile.jpg" class="rounded-pill" style="width:100px; height:100px;" alt="Avatar">
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
                    <a class="nav-link text-dark active" data-toggle="tab" href="#mylists">Lists</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" data-toggle="tab" href="#myreviews">Reviews</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" data-toggle="tab" href="#myfriends">Friends</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="mylists">
            <div class="row m-1 p-10">
                <?php $sql = "SELECT * FROM lists WHERE user_id = :user_id";
                $query = $db->prepare($sql);
                $query->execute(array(':user_id'=>$user_id)); ?>
                <div class="row row-cols-1 row-cols-md-4 g-2 p-3">
                    <?php while ($record = $query->fetch()) { ?>
                        <a href="open_list.php?list_id=<?php echo $record['list_id'];?>">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                            <h5 class="card-title"><?php echo $record['title'] ?></h5>
                                    </div>
                                </div>
                            </div>
                        </a>    
                    <?php } $query->closeCursor(); ?>
                </div>
                <a href="lists_page.php" class="m-2">Add more?</a>
            </div>
        </div>

        <div class="tab-pane fade" id="myreviews">
            <div class="row m-1 p-10">
                <?php $sql = "SELECT review_id, user_id, title, reviews.rating, review_text, movies.movie_id as id 
                FROM reviews JOIN movies ON reviews.movie_id = movies.movie_id WHERE user_id = :user_id";
                $query = $db->prepare($sql);
                $query->execute(array(':user_id'=>$user_id)); ?>
                <div class="row row-cols-1 row-cols-md-4 g-2 p-3">
                    <?php while ($record = $query->fetch()) { ?>
                        <a href="open_review.php?review_id=<?php echo $record['review_id'];?>&creator=<?php echo $search_value; ?>">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php echo $record['title'];?><br/>
                                        </h5>

                                        <p class="card-text">
                                            <?php echo 'Rating:'.$record['rating'].'/5'.'<br/>';
                                            echo $record['review_text'].'<br/>'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a> 
                    <?php } $query->closeCursor(); ?>
                </div>
                <a href="reviews_page.php" class="m-2">Add more?</a>
            </div>
        </div>

        <div class="tab-pane fade" id="myfriends">
        <div class="row m-1 p-10">
                <?php $sql = "SELECT user_id, username FROM users JOIN friends ON user_id=user_id2 WHERE user_id1 = :user_id;";
                $query = $db->prepare($sql);
                $query->execute(array(':user_id'=>$user_id)); ?>
                <div class="row row-cols-1 row-cols-md-4 g-2 p-3">
                    <?php while ($record = $query->fetch()) { ?>
                        <a href="public_profile.php?search_value=<?php echo $record['username']; ?>&user_id=<?php echo $record['user_id']; ?>">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php echo $record['username'];?><br/>
                                        </h5>
                                    </div>
                                </div>
                            </div> 
                        </a>
                    <?php } $query->closeCursor();
                    $db = null; ?>
                </div>
                <a href="#" class="m-2">Add more?</a>
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