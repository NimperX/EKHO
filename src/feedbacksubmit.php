<?php
session_start();

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $feedback = $_POST['feedback'];
    include('db.php');
    $conn  = $mysqli->query("INSERT INTO `complaint`(`name`,`complain`) VALUES('$name','$feedback');");

    $name = $mysqli->real_escape_string($name);
    $feedback = $mysqli->real_escape_string($feedback);

    if($mysqli->errno)
        $_SESSION['alert_danger'] = true;
    else
        $_SESSION['alert_success'] = true;

    $mysqli->close();
    header('Location:../contact.php');
}

?>