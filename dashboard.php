<?php

     function updateData($userid) {
        include('src/db.php');
        global $query,$query1,$query3;
        $query = $mysqli->query("SELECT * FROM `customer` WHERE `c_id`='$userid' LIMIT 1;");
        $query1 = $mysqli->query("SELECT * from `event` WHERE `c_id`='$userid' ORDER BY `date` ASC;");
        $query3 = $mysqli->query("SELECT * FROM `room_book` rb JOIN `room` r ON rb.r_id=r.r_id WHERE `c_id`='$userid' ORDER BY `duration_from` ASC;");

        if($query->num_rows){
            global $data;
            $data = $query->fetch_assoc();
        }
    }

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


    if(session_status() == PHP_SESSION_NONE) 
    session_start();
    
    if(isset($_SESSION['userid']))
        $userid = $_SESSION['userid'];
    else
        header("Location:signin.php");

    include_once('src/header.php');

    $error = "";
    $isError = false;
    $isUpdated = false;

    updateData($userid);

    if(isset($_POST['update'])){
        include('src/db.php');

        $firstname = $mysqli->real_escape_string($_POST['firstname']);
        $lastname = $mysqli->real_escape_string($_POST['lastname']);
        $email = $mysqli->real_escape_string($_POST['email']);
        
        $contactno = $mysqli->real_escape_string($_POST['contactno']);
        $cc_no = $mysqli->real_escape_string($_POST['cc_no']);
        $exp_date = $mysqli->real_escape_string($_POST['exp_date']);
        $cvv = $mysqli->real_escape_string($_POST['cvv']);

        //echo "<script>console.log('Debug Objects: " . $email . "' );</script>";

        if(strlen($cc_no)!=16){
            $isError = true;
            $error = "Invalid credit card number found!";
        }else {
            $query = $mysqli->query("UPDATE customer SET firstname = '".$firstname."',  lastname = '".$lastname."', contactno = '".$contactno."', cc_no = '".$cc_no."' , exp_date = '".$exp_date."', cvv = '".$cvv."' WHERE email = '".$email."';");
            $isUpdated = true;
            updateData($userid);
            $mysqli->close();
        }

    }

    if(isset($_POST['edit'])){
        ?>

        <div class="container">
    <div class="row mt-5 pt-5">
        <div class="col text-left">
            <h1>
                My account
            </h1>
        </div>

         

 <form method="post" action="dashboard.php">
        <div class="col text-right">
           
                <button class="btn btn-up" type="submit" name="update">Update</button>
           
        </div>
        
    </div>

    <?php if($isError){ ?>
            
           <div class="alert alert-warning">
             <strong>Warning!</strong> <?php echo $error ?>
          </div>

      <?php } ?>

          <?php if($isUpdated){ ?>
            
           <div class="alert alert-success">
             <strong>Success!</strong> profile updated successfully.
          </div>

        <?php } ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstname">First name</label>
                    <input type="text" name="firstname" class="form-control" placeholder="First name" value="<?php echo $data['firstname']; ?>" required />
                </div>
                <div class="form-group col-md-6">
                    <label for="lastname">Last name</label>
                    <input type="text" name="lastname" class="form-control" placeholder="Last name" value="<?php echo $data['lastname']; ?>" required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="email">Email address</label>
                    <input type="email" name="emailD" class="form-control" placeholder="Email address" value="<?php echo $data['email']; ?>" disabled required/>
                    <input type="hidden" name="email" value="<?php echo $data['email']; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $data['password']; ?>" disabled required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="contactno">Contact No.</label>
                    <input type="text" name="contactno" class="form-control" placeholder="Contact No(Format: +94xxxxxxxxx)" value="<?php echo $data['contactno']; ?>" maxlength="12" required />
                </div>
                <div class="form-group col-md-6">
                    <label for="nic_passport">NIC/Passport No.</label>
                    <input type="text" name="nic_passport" class="form-control" placeholder="NIC/Passport No." value="<?php echo $data['nic_passport']; ?>" maxlength="12" disabled  required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cc_no">Credit Card No.</label>
                    <input type="text" name="cc_no" class="form-control" placeholder="Credit Card No." value="<?php echo $data['cc_no']; ?>" maxlength="16"  required />
                </div>
                <div class="form-group col-md-3">
                    <label for="exp_date">Expire date</label>
                    <input type="text" name="exp_date" class="form-control" placeholder="mm/yyyy" value="<?php echo $data['exp_date']; ?>" maxlength="7"  required />
                </div>
                <div class="form-group col-md-3">
                    <label for="cvv">CVV</label>
                    <input type="text" name="cvv" class="form-control" placeholder="CVV" maxlength="3" value="<?php echo $data['cvv']; ?>" required />
                </div>
            </div>
        </div>

     </form>
        <?php if($query1->num_rows){ ?>
        <div class="row">
            <div class="col">
                <h3>My bookings</h3>
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Event type</th>
                        <th>Date</th>
                        <th>No. of Seats</th>
                        <th>Facilities</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        $i=0;
                        while($row = $query1->fetch_assoc()){
                            $i++;
                            echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.$row['event_type'].'</td>
                                <td>'.$row['date'].'</td>
                                <td>'.$row['no_of_seats'].'</td>
                                <td><ul>';
                                $e_id = $row['e_id'];
                                $query2 = $mysqli->query("SELECT * FROM `event_facility` ef JOIN `facility` f ON ef.f_id = f.f_id WHERE ef.e_id='$e_id';");
                                if($query2->num_rows){
                                    while($row1 = $query2->fetch_assoc()){
                                        echo '<li>'.$row1['facility'].'</li>';
                                    }
                                }
                            echo '</ul></td>
                            <td><a href="src/deletehallroom.php?hall='.$row['e_id'].'"><button class="btn btn-danger">Delete</button></a></td></tr>';
                        }
                    ?>
                </table>
            </div>
        </div>
        <?php } ?>

        <?php if($query3->num_rows){ ?>
        <div class="row">
            <div class="col">
                <h3>My Reservation</h3>
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Room type</th>
                        <th>Room size</th>
                        <th>AC/Non-AC</th>
                        <th>Duration-from</th>
                        <th>Duration-to</th>
                        <th>Ordered date</th>
                        <th>Amount</th>
                        <th>Other features</th>                        
                        <th>Actions</th>
                    </tr>
                    <?php
                        $i=0;
                        while($row = $query3->fetch_assoc()){
                            $i++;
                            echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.$row['room_name'].'</td>
                                <td>'.$row['room_size'].' person</td>
                                <td>'.($row['AC']==1?'AC':'Non-AC').'</td>
                                <td>Rs.'.$row['duration_from'].'</td>
                                <td>'.$row['duration_to'].'</td>
                                <td>'.$row['ordered_date'].'</td>
                                <td>Rs.'.displayPrice($row['amount']).'.00</td>
                                <td>'.$row['other_features'].'</td>
                                <td><a href="src/deletehallroom.php?room='.$row['id'].'"><button class="btn btn-danger">Delete</button></a></td></tr>';
                        }
                    ?>
                </table>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php
    }else { ?>
        <div class="container">
    <div class="row mt-5 pt-5">
        <div class="col text-left">
            <h1>
                My account
            </h1>
        </div>

        <div class="col text-right">
            <form method="post" action="dashboard.php">
                <button class="btn btn-edit" type="submit" name="edit">Edit</button>
            </form>
        </div>
        
    </div>

      <?php if($isError){ ?>
            
           <div class="alert alert-warning">
             <strong>Warning!</strong> <?php echo $error ?>
          </div>

      <?php } ?>

          <?php if($isUpdated){ ?>
            
           <div class="alert alert-success">
             <strong>Success!</strong> profile updated successfully.
          </div>

        <?php } ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstname">First name</label>
                    <input type="text" name="firstname" class="form-control" placeholder="First name" value="<?php echo $data['firstname']; ?>" disabled/>
                </div>
                <div class="form-group col-md-6">
                    <label for="lastname">Last name</label>
                    <input type="text" name="lastname" class="form-control" placeholder="Last name" value="<?php echo $data['lastname']; ?>" disabled/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Email address" value="<?php echo $data['email']; ?>" disabled/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $data['password']; ?>" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="contactno">Contact No.</label>
                    <input type="text" name="contactno" class="form-control" placeholder="Contact No(Format: +94xxxxxxxxx)" value="<?php echo $data['contactno']; ?>" maxlength="12" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label for="nic_passport">NIC/Passport No.</label>
                    <input type="text" name="nic_passport" class="form-control" placeholder="NIC/Passport No." value="<?php echo $data['nic_passport']; ?>" maxlength="12" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cc_no">Credit Card No.</label>
                    <input type="text" name="cc_no" class="form-control" placeholder="Credit Card No." value="<?php echo $data['cc_no']; ?>" maxlength="16"  disabled />
                </div>
                <div class="form-group col-md-3">
                    <label for="exp_date">Expire date</label>
                    <input type="text" name="exp_date" class="form-control" placeholder="mm/yyyy" value="<?php echo $data['exp_date']; ?>" maxlength="7" disabled />
                </div>
                <div class="form-group col-md-3">
                    <label for="cvv">CVV</label>
                    <input type="text" name="cvv" class="form-control" placeholder="CVV" maxlength="3" value="<?php echo $data['cvv']; ?>" disabled />
                </div>
            </div>
        </div>
        <?php 

        include('src/db.php');

        if($query1->num_rows){ ?>
        <div class="row">
            <div class="col">
                <h3>My bookings</h3>
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Event type</th>
                        <th>Date</th>
                        <th>No. of Seats</th>
                        <th>Facilities</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        $i=0;
                        while($row = $query1->fetch_assoc()){
                            $i++;
                            echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.$row['event_type'].'</td>
                                <td>'.$row['date'].'</td>
                                <td>'.$row['no_of_seats'].'</td>
                                <td><ul>';
                                $e_id = $row['e_id'];
                                $query2 = $mysqli->query("SELECT * FROM `event_facility` ef JOIN `facility` f ON ef.f_id = f.f_id WHERE ef.e_id='$e_id';");
                                if($query2->num_rows){
                                    while($row1 = $query2->fetch_assoc()){
                                        echo '<li>'.$row1['facility'].'</li>';
                                    }
                                }
                            echo '</ul></td>
                            <td><a href="src/deletehallroom.php?hall='.$row['e_id'].'"><button class="btn btn-danger">Delete</button></a></td></tr>';
                        }
                    ?>
                </table>
            </div>
        </div>
        <?php } ?>

        <?php if($query3->num_rows){ ?>
        <div class="row">
            <div class="col">
                <h3>My Reservation</h3>
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Room type</th>
                        <th>Room size</th>
                        <th>AC/Non-AC</th>
                        <th>Duration-from</th>
                        <th>Duration-to</th>
                        <th>Ordered date</th>
                        <th>Amount</th>
                        <th>Other features</th>                        
                        <th>Actions</th>
                    </tr>
                    <?php
                        $i=0;
                        while($row = $query3->fetch_assoc()){
                            $i++;
                            echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.$row['room_name'].'</td>
                                <td>'.$row['room_size'].' person</td>
                                <td>'.($row['AC']==1?'AC':'Non-AC').'</td>
                                <td>'.$row['duration_from'].'</td>
                                <td>'.$row['duration_to'].'</td>
                                <td>'.$row['ordered_date'].'</td>
                                <td>Rs.'.displayPrice($row['amount']).'.00</td>
                                <td>'.$row['other_features'].'</td>
                                <td><a href="src/deletehallroom.php?room='.$row['id'].'"><button class="btn btn-danger">Delete</button></a></td></tr>';
                        }
                    ?>
                </table>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
   <?php }
?>



<?php 
    include_once('src/footer.php');
?>