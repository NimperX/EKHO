<?php
    if(session_status() == PHP_SESSION_NONE) 
    session_start();
    
    if(isset($_SESSION['userid']))
        $userid = $_SESSION['userid'];
    else
        header("Location:signin.php");

    include_once('src/header.php');

    include('src/db.php');
    $query = $mysqli->query("SELECT * FROM `customer` WHERE `c_id`='$userid' LIMIT 1;");

    if($query->num_rows){
        $data = $query->fetch_assoc();
    }
?>
<div class="container">
    <div class="row mt-5 pt-5">
        <div class="col text-center">
            <h1>
                My account
            </h1>
        </div>
    </div>
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
                    <input type="text" name="cc_no" class="form-control" placeholder="Credit Card No." value="<?php echo $data['cc_no']; ?>" maxlength="16" disabled />
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
    </div>
</div>
<?php 
    include_once('src/footer.php');
?>