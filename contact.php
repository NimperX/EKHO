<?php
    include_once('src/header.php');
    if(session_status() == PHP_SESSION_NONE) session_start();
?>
<div class="container">
    <div class="row mt-5 mb-4 pt-5 ">
        <div class="col text-center">
            <h1>
                Contact Us
            </h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION['alert_success'])){  ?>

    <div class="row">
        <div class="col text-center">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success:</strong> Your feedback has been recorded!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <?php } elseif(isset($_SESSION['alert_danger'])){ ?>

    <div class="row">
        <div class="col text-center">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> Error occured while recording your feedback!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>

    <?php } unset($_SESSION['alert_success']); unset($_SESSION['alert_danger']); ?>

    <div class="row">
        <div class="col-md-6">
            <img src="img/Gallery-Facilities-2.jpg" class="img-fluid" />
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col text-left">
                    <h3>
                        We value your feedback! Directly contact us for any feedback or complain.
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        Your identity will be held anonymous.
                    </p>
                </div>
            </div>
            <form method="post" action="src/feedbacksubmit.php">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Your Name" />
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="feedback" placeholder="Your feedback" rows="7"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-outline-gold" type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
    include_once('src/footer.php');
?>