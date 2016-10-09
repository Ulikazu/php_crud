<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	} else {

		if (isset($_GET['id'])) {

			if (isset($_POST['edit'])) {


				$updatequery = "UPDATE clients SET client_name = :clientname, client_address = :clientaddress, client_contact_name = :clientcontactname, client_contact_phone = :clientcontactphone, zipcodes_zipcode_id = :zipcode WHERE client_id = :clientid";
				$updatestatement = $link->prepare($updatequery);
				$updatestatement->bindParam(":clientid", $_GET['id'], PDO::PARAM_INT);
				$updatestatement->bindParam(":clientname", $_POST['client_name'], PDO::PARAM_STR);
				$updatestatement->bindParam(":clientaddress", $_POST['client_address'], PDO::PARAM_STR);
				$updatestatement->bindParam(":clientcontactname", $_POST['client_contact_name'], PDO::PARAM_STR);
				$updatestatement->bindParam(":clientcontactphone", $_POST['client_contact_phone'], PDO::PARAM_STR);
				$updatestatement->bindParam(":zipcode", $_POST['zipcode'], PDO::PARAM_INT);

				if ($updatestatement->execute()) {
				} else {
					print_r($updatestatement->errorInfo());
				}
			}
			
			$sql_query = "SELECT c.*, z.zipcode_city FROM clients c, zipcodes z WHERE c.client_id = :clientid AND z.zipcode_id = c.zipcodes_zipcode_id";
			$records = $link->prepare($sql_query);
			$records->bindParam(':clientid', $_GET['id'],PDO::PARAM_INT);


			if ($records->execute()) {
				$projectquery = "SELECT * FROM projects WHERE clients_client_id = :clientid";
				$projectrecords = $link->prepare($projectquery);
				$projectrecords->bindParam(':clientid', $_GET['id'], PDO::PARAM_INT);
				$projectrecords->execute();
				$client = $records->fetch(PDO::FETCH_ASSOC);

				$zipcode_query = "SELECT * FROM zipcodes";
				$zipcodestatement = $link->prepare($zipcode_query);
				$zipcodestatement->execute();

			}


		} else {
			header("Location: clients.php");
		}

	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Client - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Client details</h1>
		<div class="action-options">
			<a href="new-client.php"><p>Register a new client</p></a>
			<a href="clients.php"><p>Manage clients</p></a>
			<a href="new-project.php"><p>Start a new project</p></a>
			<a href="projects.php"><p>Manage projects</p></a>
		</div>
		<div class="list-section">
			<div class="clients-section">
				<h2><?= $client['client_name'] ?></h2>
				<div class="client-item">
					<h3>Contact info:</h3>
					<p>Contact person: <?= $client['client_contact_name'] ?></p>
					<p>Phone number: <?= $client['client_contact_phone'] ?></p>
					<hr>
					<h4><strong>Address:</strong></h4>
					<p><?= $client['client_address'].'<br>'.$client['zipcodes_zipcode_id'].' '.$client['zipcode_city'] ?></p>
				</div>

				<div class="edit">
					<h3>Edit info:</h3>
					<form action="<?= $_SERVER['PHP_SELF'].'?id='.$_GET['id'] ?>" method="post">
						<input type="text" name="client_name" value="<?= $client['client_name'] ?>" placeholder="Name" required>
						<input type="text" name="client_address" value="<?= $client['client_address'] ?>" placeholder="Address" required>
						<input type="text" name="client_contact_name" value="<?= $client['client_contact_name'] ?>" placeholder="Name of contact" required>
						<input type="text" name="client_contact_phone" value="<?= $client['client_contact_phone'] ?>" placeholder="Phone number of contact" required>
						<select name="zipcode" required>
							<?php 

							while ($zipcode = $zipcodestatement->fetch(PDO::FETCH_ASSOC)) {
								?>

								<option <?= $zipcode['zipcode_id'] == $client['zipcodes_zipcode_id'] ? 'selected' : '' ?> value="<?= $zipcode['zipcode_id'] ?>"><?= $zipcode['zipcode_id'].' - '.$zipcode['zipcode_city'] ?></option>

								<?php
							}

					 		?>
						</select>
						<input type="submit" name="edit" value="Apply changes">
					</form>
					<form>
						<p class="error"><a href="delete-client.php?id=<?= $_GET['id'] ?>">Delete client</a></p>
					</form>
				</div>
			</div>
			<div class="project-section">
				<h2>Projects</h2>

				<?php 


				while ($project = $projectrecords->fetch(PDO::FETCH_ASSOC)) {
					?>
					
					<p><a href="project.php?id=<?= $project['project_id'] ?>"><?= $project['project_name'] ?></a></p>

					<?php
				}

				 ?>
			</div>
		</div>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
	</div>
</body>
</html>