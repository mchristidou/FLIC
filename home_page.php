<?php 
    session_start();

    require('db_conn.php');

    $title = "FLIC - Film Lovers Interacting & Connecting";

    require('header.php');
    require('nav.php');
    require('functions.php');
?>

<main id="main" class="flex-grow-1">

    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="homepage/spirited.jpg" class="d-block w-100" alt="...">
                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>Get started with FLIC.</h1>
                        <p>Start tracking, rating, and sharing your film experiences by using FLIC's platform.</p>
                        <?php if (!isset($_SESSION['user_id'])) { ?>
                            <p><a class="btn btn-lg btn-light" href="signup.php">Sign up today</a></p>
                        <?php } else { ?>
                            <p><a class="btn btn-lg btn-light" href="myprofile.php">Sign up today</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="homepage/inception.jpg" class="d-block w-100" alt="...">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Review movies you've watched.</h1>
                        <p>Your unique take on movies helps others discover new favorites and sparks lively discussions.</p>
                        <?php if (!isset($_SESSION['user_id'])) { ?>
                            <p><a class="btn btn-lg btn-light" href="user_page.php">Learn more</a></p>
                        <?php } else { ?>
                            <p><a class="btn btn-lg btn-light" href="reviews_page.php">Learn more</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="homepage/lalaland.jpg" class="d-block w-100" style="object-position:left bottom;" alt="...">
                <div class="container">
                    <div class="carousel-caption text-end">
                        <h1>Create unique lists.</h1>
                        <p>Create lists for any mood, theme, or cinematic adventure.</p>
                        <?php if (!isset($_SESSION['user_id'])) { ?>
                            <p><a class="btn btn-lg btn-light" href="user_page.php">Browse films</a></p>
                        <?php } else { ?>
                            <p><a class="btn btn-lg btn-light" href="films_page.php">Browse films</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>

    <div class="container container-expand-sm text-center" style="padding:15px; width:200;">
        <?php echo_msg(); ?>
    </div>

    <div class="container headings">
        <div class="row">
            <div class="col-lg-4">
                <img src="homepage/boy_review.jpg" alt="..." width="140" height="140" class="shadow shadow-strong-lg rounded-circle" />
                <!--<svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>-->

                <div class="m-3">
                    <h2>Reviews, Effortlessly</h2>
                    <p>Craft detailed reviews, assign star ratings, and document your personal connection to every film you experience.</p>
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <p><a class="btn btn-dark" href="user_page.php">Write a Review &raquo;</a></p>
                    <?php } else { ?>
                        <p><a class="btn btn-dark" href="reviews_page.php">Write a Review &raquo;</a></p>
                    <?php } ?>
                </div>
            </div>

            <div class="col-lg-4">
                <img src="homepage/watching.jpg" alt="..." width="140" height="140" class="shadow shadow-strong-lg rounded-circle" />
                <!--<svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>-->
                <div class="m-3">
                    <h2>Find Your Next Watch</h2>
                    <p>Get inspired by trending titles, popular genres, and personalized recommendations curated just for you.</p>
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <p><a class="btn btn-dark" href="user_page.php">Discover Movies &raquo;</a></p>
                    <?php } else { ?>
                        <p><a class="btn btn-dark" href="films_page.php">Discover Movies &raquo;</a></p>
                    <?php } ?>
                </div>
            </div>

            <div class="col-lg-4">
                <img src="homepage/organize.jpg" alt="..." width="140" height="140" class="shadow shadow-strong-lg rounded-circle" />
                <!--<svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>-->

                <div class="m-3">
                    <h2>Organize Your Watchlist</h2>
                    <p>Keep track of movies you want to see, films you've loved, or even your guilty pleasures with custom lists.</p>
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <p><a class="btn btn-dark" href="user_page.php">Create a List &raquo;</a></p>
                    <?php } else { ?>
                        <p><a class="btn btn-dark" href="lists_page.php">Create a List &raquo;</a></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</main>

<?php require('footer.php'); ?>