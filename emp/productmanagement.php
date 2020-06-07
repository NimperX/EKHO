<?php
    if(session_status() == PHP_SESSION_NONE) 
        session_start();

    if(!isset($_SESSION['empid']))
        header('Location:index.php');

    include('../src/header-emp.php');


    include('../src/db.php');


    $events = $mysqli->query("SELECT * FROM `event_types`;");

    

		

			function loadEventsTable($events){
				echo '<table border="1" style="width:40%;text-align:center;">

				<th>ID</th><th>Event Type</th><th>Action</th>

				';
          
                         while($row = $events->fetch_assoc()){
                         	echo '
                         	<tr>
                         	<td>'.$row['type_id'].'</td>
                         	<td>'.$row['name'].'</td>
                         	<td><form method="post" action="productmanagement.php">
                         	<input type="hidden" name="id" value="'.$row['type_id'].'">
                         	<input type="submit" name="delete" value="Delete" style="background-color:red;color:white;border: none;padding: 5px 10px;
  text-align: center;
  text-decoration: bold;
  display: inline-block;"></form></td>
                         	</tr>';
                         }
                         echo '</table>';

			}


			$isError = false;
			$error = "";

			if(isset($_POST['ADD_EVENT'])){
				$event_type = $mysqli->real_escape_string($_POST['event_type']);
				if($event_type == ""){
					$isError = true;
					$error = "Event Type is required!";
				}else {
					$isError = false;
					$error = "";

					$query = $mysqli->query("INSERT INTO `event_types`(`name`) VALUES('$event_type');");
					$events = $mysqli->query("SELECT * FROM `event_types`;");
				}
			}


			if(isset($_POST['delete'])){

				// echo '<script>
				// console.log("Hello world!");

				// </script>';

				$id =$_POST['id'];

				$query = $mysqli->query("DELETE FROM `event_types` WHERE `type_id` = $id;");
				$events = $mysqli->query("SELECT * FROM `event_types`;");

			}
?>

<div >

	<div class="container mt-5 pt-5">
		<h2> Event Types </h2>
	</div>

	<div style="margin-left: 150px;margin-top: 20px;margin-bottom: 40px;">
		<form method="post" action="productmanagement.php">
			<label> Event Type </label>
			<input type="text" name="event_type" style="margin-left: 20px;">
			<input type="submit" name="ADD_EVENT" value="Add New Event" style="margin-left: 20px;margin-bottom: 40px;background-color:#4CAF50;color:white;border: none;padding: 5px 10px;
  text-align: center;
  text-decoration: bold;
  display: inline-block;"

			>
		</form>


		<?php
		if($isError){ ?>

           <div class="alert alert-warning" style="width: 400px;">
             <strong>Warning!</strong><?php echo $error ?>;
          </div>

         <?php } ?>


		<?php

			loadEventsTable($events);
		?>




	</div>

</div>