<?php
    include_once('src/header.php');

    include('src/db.php');

    $query = $mysqli->query("SELECT * FROM `room`;");

    
?>
<div class="room-header"></div>
<div class="container">
    <div class="row">
        <div class="col text-center mt-3">
            <h1>Room Reservations</h1>
        </div>
    </div>
    <?php 
    if($query->num_rows){
        $i=1;
        while($room = $query->fetch_assoc()){
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3" style="overflow:hidden;">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <img class="img-fluid" src="img/Gallery-Rooms-<?php echo $i; $i++; ?>.jpg" />
                        </div>
                        <div class="col-md-8 mb-3">
                            <h3><?php echo $room['room_name']; ?></h3>
                            <table>
                                <tr>
                                    <td>AC/Non-AC</td><td>: <?php if($room['AC']) echo 'AC'; else echo 'Non-AC'; ?></td>
                                </tr>
                                <tr>
                                    <td>Room Size</td><td>: 
                                        <?php 
                                            if($room['room_size']==1) echo 'Single';
                                            elseif($room['room_size']==2) echo 'Double';
                                            else echo 'Triple';
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Amount</td><td>: Rs. <? echo $room['Amount']; ?></td>
                                </tr>
                            </table>
                            <h5>Room Amenities</h5>
                            <?php
                                $services = explode(',',$room['other_features']);
                            ?>
                            <ul type="rounded">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                                for($j=0;$j<count($services);$j++){
                                                    echo '<li>'.$services[$j].'</li>';
                                                    if($j==intdiv(count($services),2)) echo '</div><div class="col-md-6">';
                                                }
                                        ?>
                                    </div>
                                </div>
                            </ul>
                            <form method="post" action="roomreserve.php">
                                <input type="hidden" name="r_id" value="<?php echo $room['r_id']; ?>">
                                <button type="submit" class="btn btn-outline-gold">Book Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
        }
    }
    ?>
</div>
<?php 
    include_once('src/footer.php');
?>