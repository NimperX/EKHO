<!DOCTYPE html>
<html>

<head>
    <title>
        EKHO Safari Tissa Hotel
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="icon" href="../img/ekho-main-logo.svg" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark " style="background:#00000077">
        <a class="navbar-brand" href="../home.php"><img src="../img/ekho-main-logo.svg" width="150" height="auto" class="d-inline-block align-top" alt="" /></a>
        <div class="form-inline my-2 my-lg-0" style="position:absolute;right:0;">
            <div class="form-group mr-3">
                <?php if(session_status() == PHP_SESSION_NONE) session_start(); if(isset($_SESSION['empid'])){ ?>
                    <a href="dashboard.php">
                        <button class="btn btn-gold my-2 my-sm-0">Dashboard</button>
                    </a>
                <?php } ?>
            </div>
            <div class="form-group mr-3">
                <?php if(session_status() == PHP_SESSION_NONE) session_start(); if(isset($_SESSION['empid'])){

                    if($_SESSION['empid'] == 1){
                 ?>
                    <a href="Productmanagement.php">
                        <button class="btn btn-gold my-2 my-sm-0">Products</button>
                    </a>
                <?php }} ?>
            </div>
            <div class="form-group mr-3">
                <?php if(isset($_SESSION['empid'])){ ?>
                    <a href="logout.php?logout">
                        <button class="btn btn-gold my-2 my-sm-0">Logout</button>
                    </a>
                <?php } ?>
            </div>
        </div>
    </nav>