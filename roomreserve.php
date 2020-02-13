<?php
    if(session_status() == PHP_SESSION_NONE) 
    session_start();

    $error = '';
    
    if(!(isset($_SESSION['r_id'])||isset($_POST['r_id'])))
        header('Location:room.php');

    if(isset($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
    }else{
        $_SESSION['r_id'] = $_POST['r_id'];
        header("Location:signin.php");
    }

    if(isset($_SESSION['r_id']))
        $r_id = $_SESSION['r_id']; 
    else
        $r_id = $_POST['r_id'];
        
    unset($_SESSION['r_id']);

    include_once('src/header.php');
    include('src/db.php');

    $query = $mysqli->query("SELECT * FROM `room` WHERE `r_id`='$r_id';");

    if($query->num_rows)
        $room = $query->fetch_assoc();

    if(isset($_POST['submit'])){
        $duration_from = $mysqli->real_escape_string($_POST['duration_from']);
        $duration_to = $mysqli->real_escape_string($_POST['duration_to']);
        $r_id = $mysqli->real_escape_string($_POST['r_id']);
        $amount = $mysqli->real_escape_string($_POST['amount']);

        $duration_from_date = new DateTime($duration_from);
        $duration_to_date = new DateTime($duration_to);

        $interval = $duration_from_date->diff($duration_to_date);
        $amount *= ($interval->d);

        $query = $mysqli->query("SELECT * FROM `room_book` WHERE (`duration_from` >= '$duration_from' AND `duration_from` <= '$duration_to') OR (`duration_to` >= '$duration_from' AND `duration_to` <= '$duration_to') AND `r_id`='$r_id';");

        if($query->num_rows){
            $error = 'This room has booked for those days. <a href="room.php">Choose another room</a>';
        }else{
            $query = $mysqli->query("INSERT INTO `room_book`(`r_id`,`c_id`,`duration_from`,`duration_to`,`amount`) VALUES('$r_id','$userid','$duration_from','$duration_to','$amount');");
            header('Location:dashboard.php');
        }
    }
?>
    <div class="container">
        <div class="row mt-5 pt-5">
            <div class="col text-center">
                <h1>Reserve room</h1>
            </div>
        </div>
        <?php if($error){ ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error : </strong><?php echo $error; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        <?php } ?>
        <form method="post">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" value="<?php echo $room['room_name']; ?>" class="form-control" disabled />   
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" value="<?php if($room['AC']) echo 'AC'; else echo 'Non-AC'; ?>" class="form-control" disabled />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" value="<?php if($room['room_size']==1) echo 'Single'; elseif($room['room_size']==2) echo 'Double'; else echo 'Triple' ?>" class="form-control" disabled />
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" value="Payment per day - Rs. <?php echo $room['Amount']; ?>.00" class="form-control" disabled />
                        <input type="hidden" name="amount" value="<?php echo $room['Amount']; ?>" />   
                    </div>
                </div>
            </div>
            <div class="form-row">
                <input type="hidden" name="r_id" value="<?php echo $r_id; ?>" />
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration_from">Duration(from):</label>
                        <input type="date" name="duration_from" class="form-control" placeholder="Duration(from)" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration_to">Duration(to):</label>
                        <input type="date" name="duration_to" class="form-control" placeholder="Duration(to)" />
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                `   <button class="btn btn-outline-gold" type="submit" name="submit">Add reservation</button>
                </div>
            </div>
        </form>
    </div>
<?php
    include_once('src/footer.php');
?>