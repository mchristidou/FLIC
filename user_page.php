<?php
    require('is_logged_in.php');

    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');
    
?>

<main id="main" class="flex-grow-1">
    <div class="container container-expand-sm text-center bg-secondary-subtle shadow rounded-5" style="margin-top:10px; padding:15px; width:200;">
        <h1>User Page</h1>
        <?php echo_msg(); ?>
    </div>
</main>

<?php require('footer.php'); ?>