<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();

$error = "";

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
} else {
    header("Location:signin.php");
}

include_once('src/header.php');
include('src/db.php');

if (isset($_POST['submit'])) {
    $event_type = $mysqli->real_escape_string($_POST['event_type']);
    $date = $mysqli->real_escape_string($_POST['date']);
    $no_of_seats = $mysqli->real_escape_string($_POST['no_of_seats']);

    $query = $mysqli->query("SELECT * FROM `event`;");

    while ($event = $query->fetch_assoc()) {
        if ($date == $event['date'])
        $error = 'Hall is booked for this date.  <a href="hall.php"> Choose another date.</a>';
    } ?>

    <?php if($error){ ?>

        <div class="row">
            <div class="col-md-6 offset-md-3 text-center signin-margin">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong><?php echo $error; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>

    <?php } 
    else
        $query = $mysqli->query("INSERT INTO `event`(`event_type`,`date`,`no_of_seats`,`c_id`) VALUES('$event_type','$date','$no_of_seats','$userid');");



    // if(!$query){
    //     $error = 'This room has booked for those days. <a href="room.php">Choose another room</a>';

    // }
}
?>


<div class="container">
    <div class="row mt-5 pt-5">
        <div class="col text-center">
            <h1>Reserve Hall</h1>
        </div>
    </div>

    <form method="post">

        <div class="form-row">
            <input type="hidden" name="e_id" value="<?php echo $e_id; ?>" />
            <div class="col-md-5">
                <div class="form-group">
                    <label for="evnt_type">Event Type</label>
                    <select class="form-control" name="event_type">
                        <option value="Wedding">Wedding</option>
                        <option value="Meeting">Meeting</option>
                        <option value="conference">Conference</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Seminar">Seminar</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Bithday party">Birthday party</option>
                        <option value="Private party">Private party</option>
                        <option value="Cocktail party">Cocktail party</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" name="date" class="form-control" placeholder="Date" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="no_of_seats">No of Seats:</label>
                    <input type="no_of_seats" name="no_of_seats" class="form-control" placeholder="No of Seats" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                ` <button class="btn btn-outline-gold" type="submit" name="submit">Add reservation</button>
            </div>
        </div>
    </form>
</div>


<?php
include_once('src/footer.php');
?>