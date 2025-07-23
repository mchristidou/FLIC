<?php 
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";
    $user_id = $_SESSION['user_id'];

    require('header.php');
    require('nav.php');
    require('functions.php');

?>

<main class="flex-grow-1">

    <div class="container container-expand-sm text-center bg-secondary-subtle shadow rounded-5" style="margin-top:10px; padding:15px;">
        <h1>Lists</h1>
    </div>
    
    <span class="border">
        <div class="container">
            <div class="row">

                <div class="col">

                    <h2>Friends Lists</h2>

                    <?php echo_msg() ?>

                    <hr>

                    <?php $user_id = $_SESSION['user_id'];
                    $sql = "SELECT * FROM lists JOIN friends ON lists.user_id = friends.user_id1 
                    JOIN users ON lists.user_id = users.user_id
                    WHERE user_id2 = :user_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id)); 
                    while ($record = $query->fetch()) { ?>
                        <div class="card mt-3">
                            <div class="card-body">
                                <a href="open_list.php?list_id=<?php echo $record['list_id'];?>" style="float:left;"><?php
                                    echo $record['title'];
                                ?></a>
                                <p><small style="float:right;"><?php echo $record['username'] ?></small></p>
                            </div>
                        </div>
                        </br>
                        <?php } 
                        $query->closeCursor(); ?>
                </div>    

                <div class="col-6"> <!--OPENED LIST IN THE CENTER -->

                    <?php $list_id = $_GET['list_id']; 
                    $sql = "SELECT lists.list_id as list_id, 
                    lists.title as list_title, lists.list_id as list_id, movies.title as movie_title, movies.movie_id as movie_id
                    FROM lists JOIN list_contents ON lists.list_id = list_contents.list_id 
                    JOIN movies ON movies.movie_id = list_contents.movie_id
                    WHERE lists.user_id = :user_id and lists.list_id = :list_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id, ':list_id'=>$list_id)); ?>

                    <!--LIST TITLE-->
                    <?php $title = "SELECT title FROM lists WHERE list_id = :list_id"; 
                    $query2 = $db->prepare($title);
                    $query2->execute(array(':list_id'=>$list_id));
                    $output = $query2->fetch(); 
                    $list_title = $output['title'];
                    $query2->closeCursor(); ?>
                    <h1><?php echo $list_title; ?></h1>

                    <!--USERNAME-->
                    <?php $creator = "SELECT username FROM lists JOIN users ON lists.user_id = users.user_id 
                    WHERE list_id = :list_id"; 
                    $query2 = $db->prepare($creator);
                    $query2->execute(array(':list_id'=>$list_id));
                    $output = $query2->fetch(); 
                    $user = $output['username'];
                    $query2->closeCursor(); ?>
                    <p><small><?php echo 'By: '.$user; ?></small></p>

                    <!--LIKE BUTTON-->
                    <?php $sql3 = "SELECT count(*) AS exist FROM list_likes WHERE user_id = :user_id AND list_id = :list_id";
                    $query3 = $db->prepare($sql3);
                    $query3->execute(array(':user_id'=>$user_id, ':list_id'=>$list_id)); 
                    $res = $query3->fetch(); 
                    if ($res['exist'] == 0) { ?>
                        <a class="btn d-flex align-items-center gap-2" id="like" type="button" href="like_list?list_id=<?php echo $list_id; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                            </svg>
                            <span>Like</span>
                        </a>
                    <?php } else if ($res['exist'] == 1) { ?>
                        <a class="btn d-flex align-items-center gap-2" id="unlike" type="button" href="like_list?list_id=<?php echo $list_id; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                            </svg>
                            <span>Unlike</span>
                        </a>
                    <?php }
                    $query3->closeCursor(); ?>

                    <hr>

                    <?php if ($query->rowCount() == 0) { ?>
                        <p style="text-align:center;">No movies added yet!</p>
                    <?php } else { ?>
                        <?php while ($record = $query->fetch()) { ?>
                            <form action="delete_list_item.php" method="get">
                                <div class="col">
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <a href="movie_page.php?movie_id=<?php echo $record['movie_id'];?>" style="float:left;"><?php
                                                echo $record['movie_title']; 
                                            ?></a>
                                            <input type="hidden" name="movie_id" id="movie_id" value="<?php echo $record['movie_id']; ?>">
                                            <input type="hidden" name="list_id" id="list_id" value="<?php echo $record['list_id']; ?>">
                                            <button class="btn btn-sm" type="submit" style="float:right;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form></br>
                        <?php } ?>
                    <?php }
                    $query->closeCursor(); ?>
                </div>

                <div class="col"> <!--MY LISTS-->

                    <h2>
                        My Lists
                        <?php echo_msg() ?>
                        <button name="submit" type="submit" id="submit" class="btn btn-dark"  style="float:right;"
                        data-bs-toggle="modal" data-bs-target="#addlist" >+ New List</button>
                    </h2>

                    <hr>

                    <div class="modal fade" id="addlist" tabindex="-1" aria-labelledby="addlistLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create a new list</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="add_list.php" method="get">
                                            <input type="text" name="list_title" id="list_title" class="form-control mb-3" placeholder="Title" maxlength="50" />
                                </div>
                                <div class="modal-footer">
                                            <button type="submit" class="btn btn-dark">Create</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $sql = "SELECT list_id, title FROM lists WHERE user_id = :user_id";
                    $query = $db->prepare($sql);
                    $query->execute(array(':user_id'=>$user_id)); 
                    while ($record = $query->fetch()) { ?>
                        <form action="delete_list.php" method="get">
                            <div class="card">
                                <div class="card-body">
                                    <a href="open_list.php?list_id=<?php echo $record['list_id'];?>" style="float:left;"><?php
                                        echo $record['title'];
                                    ?></a>
                                    <input type="hidden" name="list_title" id="list_title" value="<?php echo $record['title']; ?>"> <!--passing info to php file -->
                                    <input type="hidden" name="list_id" id="list_id" value="<?php echo $record['list_id']; ?>">
                                    <div class="dropdown">
                                        <button class="btn" type="button" style="float:right;" data-bs-toggle="dropdown" aria-expanded="false">
                                            ...
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><button class="dropdown-item" type="button"
                                            data-bs-target="#renamelist_<?php echo $record['list_id']; ?>" data-bs-toggle="modal">Rename</button></li> <!-- error -->
                                            <li><button class="dropdown-item" type="submit" name="submit" value="del">Delete</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form></br>

                        <!--Dynamic Modal ID -->
                        <div class="modal fade" id="renamelist_<?php echo $record['list_id']; ?>" tabindex="-1" aria-labelledby="renamelistLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="renameLabel">Rename list</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="update_list.php" method="get">
                                            <input type="text" name="list_title" id="list_title" class="form-control mb-3" placeholder="Title" maxlength="50" />
                                            <input type="hidden" name="list_id" id="list_id" value="<?php echo $record['list_id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                            <button type="submit" name="submit" value="rename" class="btn btn-dark">Rename</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    $query->closeCursor();
                    $db = null; ?>
                </div>    
            </div>
        </div>
    </span>
</main>

<?php require('footer.php'); ?>