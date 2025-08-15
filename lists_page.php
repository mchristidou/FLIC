<?php 
    session_start();

    require('db_conn.php');
    
    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');

?>

<main id="main" class="flex-grow-1"> <!--flex grow helps footer to be at the bottom -->
    <div class="container container-expand-sm text-center bg-secondary-subtle shadow rounded-5" style="margin-top:10px; padding:15px;">
        <h1>Movie Lists</h1>
    </div>

    <span class="border">
        <div class="container">
            <div class="row">
                <div class="col-8">

                    <!-- Display message if any -->
                    <?php echo_msg() ?>

                    <h2>
                        My Lists
                        <!-- Button trigger modal to add new list -->
                        <button name="submit" type="submit" id="submit" class="btn btn-dark" style="float:right;"
                        data-bs-toggle="modal" data-bs-target="#addlist" >+ New List</button>
                    </h2>

                    <hr>

                    <div class="modal fade" id="addlist" tabindex="-1" aria-labelledby="addlistLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
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

                    <div style="overflow-y: auto; max-height: 450px;">
                        <!-- Fetch and display user's lists -->
                        <?php $user_id = $_SESSION['user_id'];
                        $sql = "SELECT list_id, title FROM lists WHERE user_id = :user_id";
                        $query = $db->prepare($sql);
                        $query->execute(array(':user_id'=>$user_id)); 
                        while ($record = $query->fetch()) { ?>
                            <form action="delete_list.php" method="get">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="open_list.php?list_id=<?php echo $record['list_id'];?>" class="text-dark" style="float:left;text-decoration:none;"><?php
                                                echo $record['title'];
                                            ?></a>

                                            <input type="hidden" name="list_title" id="list_title" value="<?php echo $record['title']; ?>">
                                            <input type="hidden" name="list_id" id="list_id" value="<?php echo $record['list_id']; ?>">
                                            <div class="dropdown">
                                                <button class="btn" type="button" style="float:right;" data-bs-toggle="dropdown" aria-expanded="false">
                                                    ...
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><button class="dropdown-item" type="button"
                                                    data-bs-target="#renamelist_<?php echo $record['list_id']; ?>" data-bs-toggle="modal">Rename</button></li>
                                                    <li><button class="dropdown-item" type="submit" name="submit" value="del">Delete</button></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form></br>
                            
                            <!--Dynamic Modal ID -->
                            <div class="modal fade" id="renamelist_<?php echo $record['list_id']; ?>" tabindex="-1" aria-labelledby="renamelistLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
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
                        if ($query->rowCount() == 0) { ?>
                            <p class="text-center">No lists added yet!</p>
                        <?php }
                        $query->closeCursor(); ?>
                    </div>
                </div>
                <div class="col">
                    <h2>Friend Lists</h2>

                    <hr>

                    <div style="overflow-y: auto; max-height: 450px;">
                        <?php $user_id = $_SESSION['user_id'];
                        $sql = "SELECT * FROM lists JOIN friends ON lists.user_id = friends.user_id2 
                        JOIN users ON lists.user_id = users.user_id
                        WHERE user_id1 = :user_id";
                        $query = $db->prepare($sql);
                        $query->execute(array(':user_id'=>$user_id));
                        while ($record = $query->fetch()) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <a href="open_list.php?list_id=<?php echo $record['list_id'];?>" class="text-dark" style="float:left;text-decoration:none;"><?php
                                        echo $record['title'];
                                    ?></a>
                                    <p><small style="float:right;"><?php echo $record['username'] ?></small></p>
                                </div>
                            </div>
                            </br>
                        <?php } 
                        if ($query->rowCount() == 0) { ?>
                            <p class="text-center">No lists found!</p>
                        <?php }
                        $query->closeCursor();
                        $db = null; ?>
                    </div>
                </div>
            </div>
        </div>
    </span>
    
</main>

<?php require('footer.php'); ?>