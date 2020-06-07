<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();

$error = "";
$success = "";

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

    $query = $mysqli->query("SELECT * FROM `event` WHERE `date`='$date';");

    if($query->num_rows)
            $error = 'Hall is booked for this date.  <a href="hall.php"> Choose another date.</a>';
    else {
        $query = $mysqli->query("INSERT INTO `event`(`event_type`,`date`,`no_of_seats`,`c_id`) VALUES('$event_type','$date','$no_of_seats','$userid');");
        $query = $mysqli->query("SELECT `e_id` FROM `event` WHERE `date`='$date';");
        $eid = $query->fetch_assoc();
        $e_id = $eid['e_id'];
        $facilities = $_POST['facility'];
        for ($i = 0; $i < count($facilities); $i++) {
            $facility=$facilities[$i];
            $query = $mysqli->query("INSERT INTO `event_facility`(`e_id`, `f_id`) VALUES('$e_id','$facility');");
        }

        $query1 = $mysqli->query("SELECT SUM(f.`amount`) as `total` FROM `event_facility` ef JOIN `facility` f ON ef.`f_id`=f.`f_id` WHERE ef.`e_id`='$e_id';");
        if($query1)
            $totals = $query1->fetch_assoc();
        
        $total = $totals['total']+(700*$no_of_seats);
        $query = $mysqli->query("UPDATE `event` SET `balance`='$total' WHERE `e_id`='$e_id';");
        if($query)
            $success = 'Hall has successfully reserved';
    }
}
?>


<div class="container">
    <div class="row mt-5 pt-5">
        <div class="col text-center">
            <h1>Reserve Hall</h1>
        </div>
    </div>
    <?php if ($error) { ?>

    <div class="row">
        <div class="col-md-6 offset-md-3 text-center">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error: </strong><?php echo $error; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>

    <?php } ?>
    <?php if ($success) { ?>
        
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success: </strong><?php echo $success; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    
        <?php } ?>
    <form method="post">

        <div class="form-row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="event_type">Event Type</label>
                    <select class="form-control" name="event_type">

                        <?php


                        $eventTypesQuery = $mysqli->query("SELECT `name` FROM `event_types`;");
                       

                         while($row = $eventTypesQuery->fetch_assoc()){

                            echo '<option value='.$row['name'].'>'.$row['name'].'</option>';
                         }

                         ?>

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
                    <label for="no_of_seats">Rs. 700 per pax</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <?php
            $query = $mysqli->query("SELECT * FROM `facility`;");
            $i=5;
            while ($i) { 
                $i--;
                $facility = $query->fetch_assoc(); ?>
                <div class="col-md-4">
                    <label class="checkbox-inline"><input type="checkbox" name="facility[]" value="<?php echo $facility['f_id']; ?>"><?php echo ' ' . $facility['facility'] . ' - Rs.' . $facility['amount'] . '.00'; ?></label>
                </div>
            <?php } ?>
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