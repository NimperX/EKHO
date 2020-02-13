<?php
    if(session_status() == PHP_SESSION_NONE) 
    session_start();
    
    if(isset($_SESSION['userid']))
        $userid = $_SESSION['userid'];
    else
        $_SESSION['r_id'] = $_POST['r_id'];
        header("Location:signin.php");

    include_once('src/header.php');
?>
    <div class="container">
        <div class="row mt-5 pt-5">
            <div class="col text-center">
                <h1>Reserve room</h1>
            </div>
        </div>
        <div class="row">
            <form method="post">
                <div class="form-row">

                </div>
            </form>
        </div>
    </div>
<?php
    include_once('src/footer.php');
?>