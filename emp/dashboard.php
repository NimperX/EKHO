<?php
    if(session_status() == PHP_SESSION_NONE) 
        session_start();

    if(!isset($_SESSION['empid']))
        header('Location:index.php');

    include('../src/header-emp.php');
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-6">
            <?php if($_SESSION['empid'] == 1){ ?>
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="circle">
                            <i class="material-icons">
                                date_range
                            </i>
                        </div>
                        <h3 class="mt-3">
                            Sales Report
                        </h3>
                        <form method="post" action="dailyreport.php">
                            <button class="btn btn-gold mt-3" type="submit" name="submit">Generate</button>
                        </form>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="circle">
                            <i class="material-icons">
                                pool
                            </i>
                        </div>
                        <h3 class="mt-3">
                            Day-to-day Services
                        </h3>
                        <p class="card-text">Make new bill</p>
                        <a href="newbill.php"><button class="btn btn-block btn-gold mt-3" type="submit" name="submit">New Bill</button></a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <?php if($_SESSION['empid'] == 1){ ?>
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="circle">
                            <i class="material-icons">
                                person
                            </i>
                        </div>
                        <h3 class="mt-3">
                            Add Employee
                        </h3>
                        <p class="card-text">Add employee to the hotel staff.</p>
                        <a href="addemp.php"><button class="btn btn-gold mt-2">Add employee</button></a>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="circle">
                            <i class="material-icons">
                                event
                            </i>
                        </div>
                        <h3 class="mt-3">
                            Events payments
                        </h3>
                        <p class="card-text">Payments for events</p>
                        <a href="findevent.php"><button class="btn btn-block btn-gold mt-2">Enter</button></a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-12">
            <?php if($_SESSION['empid'] == 1){ ?>
                <h1>Upcoming events</h1>
                <table class="table">
                    <tr><th>#</th><th>Event type</th><th>Date</th><th>No. of seats</th><th>Full amount(Rs.)</th><th>Balance to be paid(Rs.)</th></tr>
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
                        $now = new DateTime();
                        $date = $now->format('Y-m-d');
                        $query = $mysqli->query("SELECT * FROM `event` WHERE `date`>='$date' ORDER BY `date` ASC;");

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
                                </tr>
                                <?php
                            }
                        }
                    ?>
                </table>
            <?php } ?>
        </div>
    </div>
</div>

<?php
    include('../src/footer-emp.php');
?>