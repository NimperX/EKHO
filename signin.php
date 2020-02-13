<?php
    if(session_status() == PHP_SESSION_NONE) 
        session_start();

    if(isset($_SESSION['userid']))
        header('Location:dashboard.php');

    include_once('src/header.php');
    $error = "";

    if(isset($_POST['submit'])){
        include('src/db.php');
        $email = $mysqli->real_escape_string($_POST['email']);
        $pass = $mysqli->real_escape_string($_POST['password']);

        $query = $mysqli->query("SELECT * FROM `customer` WHERE `email`='$email' LIMIT 1");

        if($query->num_rows){

            $rows = $query->fetch_assoc();

            if($rows['password'] == $pass){
                $_SESSION['userid'] = $rows['c_id'];
                if(isset($_SESSION['r_id'])){
                    header('Location:roomreserve.php');
                }else{
                    header('Location:dashboard.php');
                }
            }else{
                $error = "Password do not match!";
            }

        }else{
            $error = "Email not found. please try again!";
        }

        $mysqli->close();
    }
?>
<div class="signin-header">
    <div class="container">

        <?php if($error){ ?>

            <div class="row">
                <div class="col-md-6 offset-md-3 text-center signin-margin">
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
            <div class="col-md-6 offset-md-3 <?php if(!$error) echo 'signin-margin'; ?>">
                <div class="card bg-light mb-3">
                    <div class="card-header text-center"><h2>Sign in</h2></div>
                    <div class="card-body">
                        <form method="post"> 
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" name="email" class="form-control" placeholder="Email address" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-gold btn-block" name="submit">Submit</button>
                            Not a user yet? <a href="signup.php">Signup here</a>
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