<?php require('db_conn.php'); ?>

<nav id="nav" class="navbar navbar-expand-sm bg-dark navbar-dark">
      <div class="container">

            <a class="navbar-brand text-uppercase text-center" href="home_page.php">
                  <img src="favicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
                  FLIC
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                  <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav">
                        <?php if (!isset($_SESSION['username'])) { ?> <!-- if not logged in -->
                              <li class="nav-item"><a class="nav-link" href="user_page.php">Films</a></li>
                              <li class="nav-item"><a class="nav-link" href="user_page.php">Lists</a></li>
                              <li class="nav-item"><a class="nav-link" href="user_page.php">Reviews</a></li>
                        <?php } else { ?>                             <!-- if logged in -->
                              <li class="nav-item"><a class="nav-link" href="films_page.php">Films</a></li>
                              <li class="nav-item"><a class="nav-link" href="lists_page.php">Lists</a></li>
                              <li class="nav-item"><a class="nav-link" href="reviews_page.php">Reviews</a></li>
                              <li class="nav-item"><a class="nav-link" href="myprofile.php">My Profile</a></li>
                              <li class="nav-item"><a class="nav-link" href="logout.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                          <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                          <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                                    </svg>
                              </a></li>
                        <?php } ?>
                  </ul>
                  
                  <?php if (isset($_SESSION['username'])) { ?>
                        <ul class="navbar-nav ms-auto">
                              <form action="search_page.php" class="d-flex" role="search" method="get">
                                    <input class="form-control me-2" id="search_value" name="search_value" value="<?php echo isset($_GET['search_value']) ? $_GET['search_value'] : null; ?>" type="search" placeholder="Search here" aria-label="Search">
                                    <button class="btn btn-outline-light" type="submit">Search</button>
                              </form>   
                        </ul>
                  <?php } ?>

                  
                  <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION['username'])) { ?> 
                              <li class="nav-item"><?php echo '<div class="nav-link active">Hi '.$_SESSION['username'].'! </div>'; ?></li>
                        <?php } else { ?>

                              <button name="submit" type="submit" id="submit" class="btn m-1 btn-outline-light" 
                              data-bs-toggle="modal" data-bs-target="#login">Log in</button></br></br>

                              <div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                          <div class="modal-content">
                                                <div class="modal-header">
                                                      <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                      <form action="user_login.php" method="post">
                                                            <input type="text" id="username" name="username" class="form-control mb-3" placeholder="Username" maxlength="25">
                                                            <input type="password" id="password" name="password" class="form-control mb-3" placeholder="Password" maxlength="25">
                                                </div>
                                                <div class="modal-footer">
                                                            <button type="submit" class="btn btn-dark">Log in</button>
                                                      </form>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                              <button name="submit" type="submit" id="submit" class="btn m-1 btn-light" 
                              data-bs-toggle="modal" data-bs-target="#signup">Sign up</button></br></br>

                              <div class="modal fade" id="signup" tabindex="-1" aria-labelledby="signupLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                          <div class="modal-content">
                                                <div class="modal-header">
                                                      <h1 class="modal-title fs-5" id="signupLabel">Create a new account</h1>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                      <form action="user_signup.php" method="post" onsubmit="return validate_form();">
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
                                                                              <?php $sql = "SELECT genres_id, name FROM genres;";
                                                                              $query = $db->prepare($sql);
                                                                              $query->execute(); 
                                                                              while ($result = $query->fetch()) { ?> 
                                                                              <option value="<?php echo $result['genres_id'] ?>">
                                                                                    <?php echo $result['name']; ?>
                                                                              </option>
                                                                              <?php } $query->closeCursor(); ?>
                                                                        </select>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                <div class="modal-footer">
                                                            <button type="submit" class="btn btn-dark">Sign up</button>
                                                      </form>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        <?php } ?>
                  </ul>    
            </div>
      </div>
</nav>