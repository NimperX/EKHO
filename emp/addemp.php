<?php
    if(session_status() == PHP_SESSION_NONE) 
        session_start();

    if(!isset($_SESSION['empid']))
        header('Location:index.php');

    include('../src/header-emp.php');
    $error = '';

    if(isset($_POST['submit'])){
        include('../src/db.php');

        $firstname = $mysqli->real_escape_string($_POST['firstname']);
        $lastname = $mysqli->real_escape_string($_POST['lastname']);
        $username = $mysqli->real_escape_string($_POST['username']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $confirm_password = $mysqli->real_escape_string($_POST['confirm_password']);
        $contactno = $mysqli->real_escape_string($_POST['contactno']);
        $nic = $mysqli->real_escape_string($_POST['nic']);

        if($password != $confirm_password){
            $error = "Password and confirm password do not match!";
        }else{
            $query = $mysqli->query("SELECT * FROM `employee` WHERE `username`='$username'");
            if($query->num_rows){
                $error = "Someone is using this username. Please try another.";
            }else{
                $query = $mysqli->query("INSERT INTO `employee`(`firstname`,`lastname`,`username`,`password`,`nic`,`contactno`) VALUES('$firstname','$lastname','$username','$password','$nic','$contactno');");

                if($mysqli->errno){
                    $error = "Error occured while saving data, try again. ".$mysqli->error;
                }else{
                    header('Location:dashboard.php?newemp=YES');
                }
            }
        }

        $mysqli->close();
    }
?>

<div class="container mt-5 pt-5">
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
            <div class="col-md-8 offset-md-2">
                <div class="card bg-light mb-5">
                    <div class="card-header text-center"><h2>Add employee</h2></div>
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
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username" required/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="contactno">Contact No.</label>
                                    <input type="text" name="contactno" class="form-control" placeholder="Contact No(Format: +94xxxxxxxxx)" maxlength="12" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nic">NIC No.</label>
                                    <input type="text" name="nic" class="form-control" placeholder="NIC" maxlength="12" required />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-gold btn-block" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php
    include('../src/footer-emp.php');
?>