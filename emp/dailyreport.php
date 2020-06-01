<?php
    if(session_status() == PHP_SESSION_NONE) 
        session_start();

    if(!isset($_SESSION['empid']))
        header('Location:index.php');

    include('../src/header-emp.php');
    
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1> Sale Report of EKHO Safari</h1>
        </div>
    </div>
    <table class="table">
        <tr><th>#</th><th>Time</th><th>Biiled by</th><th class="text-right">Amount(Rs.)</th></tr>
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
            $query = $mysqli->query("SELECT * FROM `sale` s JOIN `employee` e ON s.`emp_id`=e.`emp_id`;");
            $total=0;
            if($query->num_rows){
                $i=0;
                
                while($row = $query->fetch_assoc()){
                    $i++;
                    echo '<tr><td>'.$i.'</td><td>'.date("H:i:s",strtotime($row['date_time'])).'</td><td>'.$row['firstname'].' '.$row['lastname'].'</td><td class="text-right">'.displayPrice($row['total']).'.00</td></tr>';
                    $total+=$row['total'];
                }
            }

            $query = $mysqli->query("SELECT * FROM `event`;");
            if($query->num_rows){
       
                
                while($row = $query->fetch_assoc()){
                    $i++;
                    echo '<tr><td>'.$i.'</td><td>'.date("H:i:s",strtotime($row['date'])).'</td><td>'.strtoupper($row['event_type']).'</td><td class="text-right">'.displayPrice($row['balance']).'.00</td></tr>';
                    $total+=$row['balance'];
                }
            }
            echo '<tr><td></td><td></td><th>Total</th><th class="text-right">Rs.'.displayPrice($total).'.00</td></tr>';
        ?>
    </table>
</div>

<?php
    include('../src/footer-emp.php');
?>