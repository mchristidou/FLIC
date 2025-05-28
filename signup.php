<?php

    $title = "FLIC - Film Lovers Communicating & Interacting";

    require('header.php');
    require('nav.php');
    require('functions.php');

?>

<main id="main" class="flex-grow-1">

    <div class="container container-expand-sm text-center bg-secondary-subtle shadow rounded-5" style="margin-top:100px; padding:15px; height:450px; width:450px;">
    
    <h2>Create a new account</h2>

    <div style="margin:0; padding-top:5px;"><?php echo_msg() ?></div>

    <form class="d-flex flex-column" style="margin-top:30px;" id="userdata" name="userdata" action="user_signup.php" method="post" onsubmit="return validate_form();" > 
        <div class="row g-3 align-items-center">
            <div class="input-group mb-3 col-sm-12">
                <input type="text" name="username" id="username" class="input-group form-control" placeholder="Username" aria-describedby="inputGroup-sizing-default" size="25" maxlength="25" />
                <span class="input-group-text" id="inputGroup-sizing-default">(8-15 characters)</span>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="mb-3 col-sm-12">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" size="25" maxlength="25" />
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-sm-12">
                <input type="text" name="email" id="email" class="form-control mb-3" placeholder="email" size="30" maxlength="100" />
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-sm-12">
                <input type="text" name="email_conf" id="email_conf" class="form-control mb-3" placeholder="email confirmation" size="30" maxlength="100" />
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="mb-3 col-sm-6">
            <input name="birthday" type="date" id="birthday" class="form-control" />
            </div>
            <div class="col-sm-6">
                <select class="form-select mb-3" id="fave_genre" name="fave_genre">
                    <option value="-1" selected="selected" >Select favorite genre</option> 
                    <?php $sql = "SELECT genres_id, name FROM genres";
                    $query = $db->prepare($sql);
                    $query->execute(); 
                    while ($result = $query->fetch()) { ?> 
                    <option value="<?php echo $result['genres_id'] ?>">
                        <?php echo $result['name']; ?>
                    </option>
                    <?php } $query->closeCursor(); $db = null; ?>
                </select>
            </div>
        </div>
     
        <div class="row g-3 align-items-center">
            <div class="col-sm-12">
                <button name="reset" type="reset" id="reset" class="btn btn-dark">Clear</button>
                <button name="submit" type="submit" id="submit" class="btn btn-dark">Sign up</button>
            </div>
        </div>  
    </form>

    </div>

</main>

<?php require('footer.php'); ?>