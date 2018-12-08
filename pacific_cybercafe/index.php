<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.min.css">
    <link rel="stylesheet" href="css/mdb.min.css">
    <style>
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Pacific Cybercafe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/signin.php">Sign in</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>


    <!-- JUMBOTRON -->
    <div class="jumbotron text-center">
        <div class="container">
            <h1>Welcome To Pacific Cybercafe</h1>
            <p>The number one gaming shop in the Philippines</p>
            <a href="pages/signin.php" class="btn btn-primary">Sign in</a>
            <a href="pages/register.php" class="btn btn-default">Register</a>
        </div>
    </div>

    <div class="album py-5">
        <div class="container">

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img class="card-img-top" src="img/1.jpg" height="225px" width="100%" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">
                                FOR OUR CUSTOMERS, FREE Galaxy Battles GEN ADMISSION 3-DAY ACCESS TICKETS.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>

                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img class="card-img-top" src="img/2.png" height="225px" width="100%" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">
                                Rules of Survival Tournament: Php 6,000 (no registration fee, pc time only)
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>

                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img class="card-img-top" src="img/3.jpg" height="225px" width="100%" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">
                                GeForce Cup 2018 | PLAYERUNKNOWN'S BATTLEGROUNDS QUALIFIER
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>

                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="page-footer font-small unique-color-dark pt-4">
        <div class="container">
            <ul class="list-unstyled list-inline text-center py-2">
                <li class="list-inline-item">
                    <h5 class="mb-1">Register for free</h5>
                </li>
                <li class="list-inline-item">
                    <a href="pages/register.php" class="btn btn-outline-white btn-rounded">Sign up!</a>
                </li>
            </ul>
        </div>
        <div class="footer-copyright text-center py-3">© 2018 Copyright:
            <a href="#"> Pacific Cybercafe</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>