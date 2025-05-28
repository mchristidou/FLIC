<?php
    session_start();

    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');
?>

<main id="main" class="flex-grow-1">
  
  <div class="container container-expand-sm text-center bg-secondary-subtle shadow rounded-5" style="margin-top:200px; padding:15px; height:300px; width:450px;">

    <h2>Login</h2>

    <div style="margin:0; padding-top:5px;"><?php echo_msg() ?></div>

    <?php  if ( !isset($_SESSION['username']) ) { ?> 

      <form class="d-flex flex-column" style="margin-top:30px;" id="userdata" name="userdata" action="user_login.php" method="post">  
        
          <div class="row g-3 align-items-center">
            <div class="col-sm-12">
              <input type="text" id="username" name="username" class="form-control mb-3" placeholder="Username" maxlength="25">
            </div>
          </div>
          
          <div class="row g-3 align-items-center">
            <div class="col-sm-12">
              <input type="password" id="password" name="password" class="form-control mb-3" placeholder="Password" maxlength="25">
            </div>
          </div>
          
          <div class="row g-3 align-items-center">
            <div class="col-sm-12">
              <button id="submit" name="submit" type="submit" class="btn btn-dark">Log in</button>
            </div>
          </div>
      </form>

    <?php  } else echo '<p>You are logged in!</p>'; ?>

  </div>

</main>

<?php require('footer.php'); ?>