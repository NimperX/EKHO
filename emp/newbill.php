<?php
    if(session_status() == PHP_SESSION_NONE) 
        session_start();

    if(!isset($_SESSION['empid']))
        header('Location:index.php');
    else
        $empid = $_SESSION['empid'];

    include('../src/header-emp.php');

    if(isset($_SESSION['s_id'])){
        $s_id = $_SESSION['s_id'];
    }else{
        $s_id = '';
    }

    if(isset($_POST['endbill'])){
        $s_id = '';
        unset($_SESSION['s_id']);
    }

    if(isset($_POST['submit'])){
        $f_id = $_POST['service'];
        $count = $_POST['count'];
        $now = new DateTime();
        $ts = $now->format('Y-m-d H:i:s');

        include_once('../src/db.php');
        if(!isset($_SESSION['s_id'])){
            $query = $mysqli->query("INSERT INTO `sale`(`date_time`,`emp_id`) VALUES('$ts','$empid');");

            if($query){
                $query = $mysqli->query("SELECT * FROM `sale` ORDER BY `s_id` DESC LIMIT 1;");

                if($query->num_rows){
                    $row = $query->fetch_assoc();
                    $s_id = $row['s_id'];
                    $_SESSION['s_id'] = $s_id;
                }
            }
        }

        $query = $mysqli->query("INSERT INTO `sale_facility`(`s_id`,`f_id`,`count`) VALUES('$s_id','$f_id','$count');");

        if($query){
            $query = $mysqli->query("SELECT SUM(sf.`count`*f.`amount`) as `total` FROM `sale_facility` sf JOIN `facility` f ON sf.`f_id`=f.`f_id` WHERE sf.`s_id`='$s_id';");
            if($query){
                $row = $query->fetch_assoc();
                $total = $row['total'];
                $query = $mysqli->query("UPDATE `sale` SET `total` = '$total' WHERE `s_id`='$s_id';");
                if(!$query)
                    echo 'Error occcured!';
            }
        }
    }
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <form method="post">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <label>Select the service</label>
                        <div class="form-row">
                            <div class="col-md-6">
                                <select name="service" class="form-control">
                                    <?php
                                        include_once('../src/db.php');

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

                                        $facilities = $mysqli->query("SELECT * FROM `facility`;");
                                        $i=0;
                                        while($facility = $facilities->fetch_assoc()){
                                            $i++;
                                            if($i<=5) continue;
                                            echo '<option value="'.$facility['f_id'].'">'.$facility['facility'].'(Rs.'.displayPrice($facility['amount']).'.00)</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="count" value="1" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <button type="submit" name="submit" class="btn btn-gold btn-block">Add to bill</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-5">
        <table class="table" style="border:1px solid #dee2e6;">
            <tr><td colspan="5"><h2>EKHO Safari Tissa Hotel</h2></td></tr>
            <tr><td colspan="5">EKHO Hotels
                South Wing,
                No. 02, Galle Road,
                Colombo 03,
                Sri Lanka</td></tr>
            <tr><th>#</th><th>Description</th><th class="text-right">Amount(Rs.)</th><th class="text-right">Count</th><th class="text-right">Price(Rs.)</th></tr>
            <?php


                $query = $mysqli->query("SELECT * FROM `sale_facility` sf JOIN `facility` f ON sf.`f_id`=f.`f_id` WHERE sf.`s_id`='$s_id';");

                if($query->num_rows){
                    $i=0;
                    while($row = $query->fetch_assoc()){
                        $i++;
                        echo '<tr><td>'.$i.'</td><td>'.$row['facility'].'</td><td class="text-right">'.displayPrice($row['amount']).'.00</td><td class="text-right">'.$row['count'].'</td><td class="text-right">'.displayPrice($row['amount']*$row['count']).'.00</td></tr>';
                    }
                }

                $query = $mysqli->query("SELECT * FROM `sale` WHERE `s_id`='$s_id';");
                if($query->num_rows){
                    $row = $query->fetch_assoc();
                    echo '<tr><td></td><td></td><td class="text-right"></td><td class="text-right"></td><th class="text-right">'.displayPrice($row['total']).'.00</td></tr>';
                }
            ?>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post">
            <button type="submit" name="endbill" class="btn btn-block btn-gold">End bill</button>
            </form>
        </div>
    </div>
</div>

<?php
    include('../src/footer-emp.php');
?>