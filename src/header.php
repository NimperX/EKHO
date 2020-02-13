<!DOCTYPE html>
<html>

<head>
    <title>
        EKHO Safari Tissa Hotel
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="img/ekho-main-logo.svg" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark " style="background:#00000077">
        <a class="navbar-brand" href="home.php"><img src="img/ekho-main-logo.svg" width="150" height="auto" class="d-inline-block align-top" alt="" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="room.php">Room reservations</a>
                        <a class="dropdown-item" href="hall.php">Hall bookings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="daytoday.php">Day-to-day services</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="about.php">About us</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="gallery.php">Gallery</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="contact.php">Contact us</a>
                </li>
            </ul>
        </div>
        <div class="form-inline my-2 my-lg-0">
            <div class="form-group mr-3">
                <?php if(session_status() == PHP_SESSION_NONE) session_start(); if(isset($_SESSION['userid'])){ ?>
                    <a href="dashboard.php">
                        <button class="btn btn-gold my-2 my-sm-0">My Account</button>
                    </a>
                <?php }else{ ?>
                    <a href="signup.php">
                        <button class="btn btn-gold my-2 my-sm-0">Signup</button>
                    </a>
                <?php } ?>
            </div>
            <div class="form-group mr-3">
                <?php if(isset($_SESSION['userid'])){ ?>
                    <a href="src/logout.php?logout">
                        <button class="btn btn-gold my-2 my-sm-0">Logout</button>
                    </a>
                <?php }else{ ?>
                    <a href="signin.php">
                        <button class="btn btn-gold my-2 my-sm-0">Login</button>
                    </a>
                <?php } ?>
            </div>
        </div>
    </nav>