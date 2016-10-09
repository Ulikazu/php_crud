<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	} else {
		// print_r($_SESSION);

		if (!empty($_POST['submit'])) {

			$client_name = $_POST['client_name'];
			$client_address = $_POST['client_address'];
			$client_contact_name = $_POST['client_contact_name'];
			$client_contact_phone = $_POST['client_contact_phone'];
			$zipcodes_zipcode_id = $_POST['zipcode'];
			
			$sql_query = "INSERT INTO clients (client_name, client_address, client_contact_name, client_contact_phone, zipcodes_zipcode_id) VALUES (:clientname, :clientaddress, :clientcontactname, :clientcontactphone, :zipcodeszipcodeid)";
			$statement = $link->prepare($sql_query);
			$statement->bindParam(':clientname', $client_name, PDO::PARAM_STR);
			$statement->bindParam(':clientaddress', $client_address, PDO::PARAM_STR);
			$statement->bindParam(':clientcontactname', $client_contact_name, PDO::PARAM_STR);
			$statement->bindParam(':clientcontactphone', $client_contact_phone, PDO::PARAM_STR);
			$statement->bindParam(':zipcodeszipcodeid', $zipcodes_zipcode_id, PDO::PARAM_STR);

			if ($statement->execute()) {
				$lastInsertId = $link->lastInsertId();
				header("Location: client.php?id=$lastInsertId");
			} else {
				echo "Something went wrong...". print_r($statement->errorInfo());
			}
		}

		$zipcode_query = "SELECT * FROM zipcodes";
		$zipcodestatement = $link->prepare($zipcode_query);
		$zipcodestatement->execute();
	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>New Client - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Register a new client</h1>
		<div class="action-options">
			<a href="new-client.php"><p>Register a new client</p></a>
			<a href="clients.php"><p>Manage clients</p></a>
			<a href="new-project.php"><p>Start a new project</p></a>
			<a href="projects.php"><p>Manage projects</p></a>
		</div>
		<p>From here you can register a new client you are going to work with.</p>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<input type="text" name="client_name" placeholder="Name" required>
			<input type="text" name="client_address" placeholder="Address" required>
			<input type="text" name="client_contact_name" placeholder="Name of contact" required>
			<input type="text" name="client_contact_phone" placeholder="Phone number of contact" required>
			<select name="zipcode" required>
				<?php 

				while ($zipcode = $zipcodestatement->fetch(PDO::FETCH_ASSOC)) {
					?>

					<option value="<?= $zipcode['zipcode_id'] ?>"><?= $zipcode['zipcode_id'].' - '.$zipcode['zipcode_city'] ?></option>

					<?php
				}

				 ?>
			</select>
			<input type="submit" name="submit" value="Register client">
		</form>
	</div>
</body>
</html>