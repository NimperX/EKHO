<?php
    include_once('src/header.php');
?>
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Day-to-day Services</h1>
        </div>
    </div>

    <?php
        include('src/db.php');
          $services = $mysqli->query("SELECT * FROM `day_to_day_services`;");
                $i = 0;
                         while($row = $services->fetch_assoc()){
                            $i += 1;
                        if($i % 3 == 1){
                            echo '
                            <div class="row">
        <div class="col-md-4">
            <img src=img/'.$row['image_uri'].' class="img-thumbnail" />
            <h3>'.$row['name'].'</h3>
            <p>Rs.'.$row['price'].'.00</p>
        </div>';
                        } else if($i % 3 == 2){

                              echo '
        <div class="col-md-4">
            <img src=img/'.$row['image_uri'].' class="img-thumbnail" />
            <h3>'.$row['name'].'</h3>
            <p>Rs.'.$row['price'].'.00</p>
        </div>';
                        } else {
                              echo '
                            
        <div class="col-md-4">
            <img src=img/'.$row['image_uri'].' class="img-thumbnail" />
            <h3>'.$row['name'].'</h3>
            <p>Rs.'.$row['price'].'.00</p>
        </div></div>';
                        }
                            

            }
    ?>

</div>
<?php 
    include_once('src/footer.php');
?>