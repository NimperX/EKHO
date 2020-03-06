<?php
if(session_status() == PHP_SESSION_NONE) 
    session_start();

if(isset($_GET['hall'])){
    $hall = $_GET['hall'];
    include_once('db.php');
    $query = $mysqli->query("DELETE FROM `event` WHERE `e_id`='$hall';");
    $query1 = $mysqli->query("DELETE FROM `event_facility` WHERE `e_id`='$hall';");
    header("Location: ../dashboard.php");
}

if(isset($_GET['room'])){
    $room = $_GET['room'];
    include_once('db.php');
    $query = $mysqli->query("DELETE FROM `room_book` WHERE `id`='$room';");
    header("Location: ../dashboard.php");
}

?>