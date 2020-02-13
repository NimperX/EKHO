<?php
if(session_status() == PHP_SESSION_NONE) 
    session_start();

if(isset($_GET['logout'])){
    unset($_SESSION['userid']);
    session_unset();
    header('Location: ../signin.php');
}

?>