<?php
    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(!isset($_SESSION['empid']))
        header('Location:index.php');

    include('../src/header-emp.php');
    $error = '';
    $success = '';

    if(isset($_POST['advance'])){
        include_once('../src/db.php');
        $advance = $mysqli->real_escape_string($_POST['advanceamount']);
        $e_id = $mysqli->real_escape_string($_POST['e_id']);

        $query = $mysqli->query("UPDATE `event` SET `advance`='$advance' WHERE `e_id`='$e_id';");

        if($query){
            $success = "Advance paid successfully.";
        }else{
            $error = "Error occured. Please try again.";
        }
    }

    if(isset($_POST['full'])){
        include_once('../src/db.php');
        $advance = $mysqli->real_escape_string($_POST['fullamount']);
        $e_id = $mysqli->real_escape_string($_POST['e_id']);

        $query = $mysqli->query("UPDATE `event` SET `advance`='$advance' WHERE `e_id`='$e_id';");

        if($query){
            $success = "Full amount paid successfully.";
        }else{
            $error = "Error occured. Please try again.";
        }
    }
?>
    <div class="container mt-5 pt-5">
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

        <table class="table">
            <tr><th>#</th><th>Event type</th><th>Date</th><th>No. of seats</th><th>Full amount(Rs.)</th><th>Balance to be paid(Rs.)</th><th>Actions</th></tr>
            <?php

                function displayPrice($price){
                $str = strval($price);
                $len = strlen($str);
                $d = 0;
                $reStr = "";
                for($i=$len-1;$i>=0;$i--){
                    $d++;
                    if($d % 3 == 0){
                        $reStr .= $str[$i] . ",";
                    } else {
                        $reStr .= $str[$i];
                    }
                }
                $output = strrev($reStr);
                if($output[0] == ','){
                    $output[0] = ' ';
                }
                return $output;
            }

                include_once('../src/db.php');
                $query = $mysqli->query("SELECT * FROM `event` ORDER BY `date` DESC;");

                if($query){
                    $i=0;
                    while($row = $query->fetch_assoc()){
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['event_type']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['no_of_seats']; ?></td>
                            <td><?php echo displayPrice($row['balance']); ?>.00</td>
                            <td><?php echo displayPrice($row['balance']-$row['advance']); ?>.00</td>
                            <td>
                                <form method="post">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <input type="number" name="advanceamount" class="form-control" placeholder="Advance amount" />
                                            <input type="hidden" name="e_id" value="<?php echo $row['e_id']; ?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-block btn-gold" name="advance">Pay advance</button>
                                        </div>
                                    </div>
                                </form>
                                <form method="post">
                                    <div class="form-row mt-2">
                                        <div class="col-md-12">
                                            <input type="hidden" name="fullamount" value="<?php echo $row['balance']; ?>" />
                                            <input type="hidden" name="e_id" value="<?php echo $row['e_id']; ?>" />
                                            <button type="submit" class="btn btn-block btn-gold" name="full">Pay full amount</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>
        </table>
    </div>

<?php   
    include('../src/footer-emp.php');
?>