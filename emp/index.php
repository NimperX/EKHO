<?php
    if(session_status() == PHP_SESSION_NONE) 
        session_start();

    if(isset($_SESSION['empid']))
        header('Location:dashboard.php');

    include_once('../src/header-emp.php');
    $error = "";

    if(isset($_POST['login'])){
        include('../src/db.php');
        $username = $mysqli->real_escape_string($_POST['username']);
        $pass = $mysqli->real_escape_string($_POST['password']);

        $query = $mysqli->query("SELECT * FROM `Employee` WHERE `username`='$username' LIMIT 1");

        if($query->num_rows){

            $rows = $query->fetch_assoc();

            if($rows['password'] == $pass){
                $_SESSION['empid'] = $rows['emp_id'];
                header('Location:dashboard.php');
            }else{
                $error = "Password do not match!";
            }

        }else{
            $error = "Username not found. please try again!";
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
                    <div class="card-header text-center"><h2>Login</h2></div>
                    <div class="card-body">
                        <form method="post"> 
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-gold btn-block" name="login">Login</button>
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
    include_once('../src/footer-emp.php');
?>