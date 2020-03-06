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
                            Daily Report
                        </h3>
                        <p class="card-text">Select date for report generation process.</p>
                        <form method="post" action="dailyreport.php">
                            <input type="date" name="date" placeholder="Select date"/>
                        </form>
                        <button class="btn btn-gold mt-3" type="submit" name="submit">Generate</button>
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
                        <a href="bill/newbill.php"><button class="btn btn-block btn-gold mt-3" type="submit" name="submit">New Bill</button></a>
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
                        <a href="addemp.php"><button class="btn btn-gold mt-2">Go somewhere</button></a>
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
    </div>
</div>

<?php
    include('../src/footer-emp.php');
?>