<?php
    include_once('src/header.php');
?>
    <div class="container"> 
        <div class="gallery-header text-center mt-5 pt-5">
            <h2>Gallery</h2>
        </div>
        <div class="row mt-3 pl-3">
            <h5>Public places</h5>
        </div>
        <div class="row mt-2 mb-5">
            <?php
            for($i=1;$i<7;$i++){
                echo '
                    <div class="col-md-3">    
                        <img src="img/Gallery-Public-Spaces-'.$i.'.jpg" class="rounded img-thumbnail" />
                    </div>';
            }
            ?>
        </div>
        <div class="row mt-3 pl-3">
            <h5>Facilities</h5>
        </div>
        <div class="row mt-2 mb-5">
            <?php
            for($i=1;$i<8;$i++){
                echo '
                    <div class="col-md-3">    
                        <img src="img/Gallery-Facilities-'.$i.'.jpg" class="rounded img-thumbnail" />
                    </div>';
            }
            ?>
        </div>
        <div class="row mt-3 pl-3">
            <h5>Rooms</h5>
        </div>
        <div class="row mt-2 mb-5">
            <?php
            for($i=1;$i<8;$i++){
                echo '
                    <div class="col-md-3">    
                        <img src="img/Gallery-Rooms-'.$i.'.jpg" class="rounded img-thumbnail" />
                    </div>';
            }
            ?>
        </div>
        <div class="row mt-3 pl-3">
            <h5>Dining</h5>
        </div>
        <div class="row mt-2 mb-5">
            <?php
            for($i=1;$i<8;$i++){
                echo '
                    <div class="col-md-3">    
                        <img src="img/Gallery-Dining-'.$i.'.jpg" class="rounded img-thumbnail" />
                    </div>';
            }
            ?>
        </div>
    </div>
<?php 
    include_once('src/footer.php');
?>