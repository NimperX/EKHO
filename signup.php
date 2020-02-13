<?php
    if(session_status() == PHP_SESSION_NONE) 
        session_start();

    if(isset($_SESSION['userid']))
        header('Location:dashboard.php');

    include_once('src/header.php');
    $error = '';

    if(isset($_POST['submit'])){
        include('src/db.php');

        $firstname = $mysqli->real_escape_string($_POST['firstname']);
        $lastname = $mysqli->real_escape_string($_POST['lastname']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $confirm_password = $mysqli->real_escape_string($_POST['confirm_password']);
        $contactno = $mysqli->real_escape_string($_POST['contactno']);
        $nic_passport = $mysqli->real_escape_string($_POST['nic_passport']);
        $cc_no = $mysqli->real_escape_string($_POST['cc_no']);
        $exp_date = $mysqli->real_escape_string($_POST['exp_date']);
        $cvv = $mysqli->real_escape_string($_POST['cvv']);

        if($password != $confirm_password){
            $error = "Password and confirm password do not match!";
        }elseif(strlen($cc_no)!=16){
            $error = "Invalid credit card number found!";
        }else{
            $query = $mysqli->query("SELECT * FROM `customer` WHERE `email`='$email'");
            if($query->num_rows){
                $error = "Someone is using this email. Please try another.";
            }else{
                $query = $mysqli->query("INSERT INTO `customer`(`firstname`,`lastname`,`email`,`password`,`contactno`,`nic_passport`,`cc_no`,`exp_date`,`cvv`) VALUES('$firstname','$lastname','$email','$password','$contactno','$nic_passport','$cc_no','$exp_date','$cvv');");

                if($mysqli->errno){
                    $error = "Error occured while saving data, try again.";
                }else{
                    $query = $mysqli->query("SELECT * FROM `customer` WHERE `email`='$email' LIMIT 1");

                    if($query->num_rows){
                        $rows = $query->fetch_assoc();

                        $_SESSION['userid'] = $rows['c_id'];
                        header('Location:dashboard.php');
                    }else{
                        $error = "Error occured while login, try again.";
                    }
                }
            }
        }

        $mysqli->close();
    }
        
?>

<div class="signin-header">
    <div class="container">

        <?php if($error){ ?>
            
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center signin-margin">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error: </strong><?php echo $error; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>

        <?php } ?>

        <div class="row">
            <div class="col-md-8 offset-md-2 <?php if(!$error) echo 'signin-margin'; ?>">
                <div class="card bg-light mb-5">
                    <div class="card-header text-center"><h2>Sign up</h2></div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstname">First name</label>
                                    <input type="text" name="firstname" class="form-control" placeholder="First name" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastname">Last name</label>
                                    <input type="text" name="lastname" class="form-control" placeholder="Last name" required/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="email">Email address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email address" required/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm_password">Password</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="contactno">Contact No.</label>
                                    <input type="text" name="contactno" class="form-control" placeholder="Contact No(Format: +94xxxxxxxxx)" maxlength="12" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nic_passport">NIC/Passport No.</label>
                                    <input type="text" name="nic_passport" class="form-control" placeholder="NIC/Passport No." maxlength="12" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cc_no">Credit Card No.</label>
                                    <input type="text" name="cc_no" class="form-control" placeholder="Credit Card No." maxlength="16" required />
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exp_date">Expire date</label>
                                    <input type="text" name="exp_date" class="form-control" placeholder="mm/yyyy" maxlength="7" required />
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cvv">CVV</label>
                                    <input type="text" name="cvv" class="form-control" placeholder="CVV" maxlength="3" required />
                                </div>
                            </div>  
                            <button type="submit" class="btn btn-gold btn-block" name="submit">Submit</button>
                            Already a user? <a href="signin.php">Login here</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    footer .container{
        margin-top:0;
    }
</style>


<?php 
    include_once('src/footer.php');
?>