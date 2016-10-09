<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	} else {

		if (isset($_GET['id'])) {


			$sqlquery = "SELECT * FROM projects WHERE project_id = :projectid";
			$statement = $link->prepare($sqlquery);
			$statement->bindParam(":projectid", $_GET['id'], PDO::PARAM_INT);

			if ($statement->execute()) {
				$project = $statement->fetch(PDO::FETCH_ASSOC);
				
				$clientquery = "SELECT * FROM clients WHERE client_id = :clientid";
				$clientstatement = $link->prepare($clientquery);
				$clientstatement->bindParam(":clientid", $project['clients_client_id'], PDO::PARAM_INT);
				$clientstatement->execute();
				$client = $clientstatement->fetch(PDO::FETCH_ASSOC);
			} else {
				print_r($statement->errorInfo());
			}


		} else {
			header("Location: projects.php");
		}

	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Project - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Project details</h1>
		<div class="action-options">
			<a href="new-client.php"><p>Register a new client</p></a>
			<a href="clients.php"><p>Manage clients</p></a>
			<a href="new-project.php"><p>Start a new project</p></a>
			<a href="projects.php"><p>Manage projects</p></a>
		</div>
		<div class="list-section">
			<div class="clients-section">
				<div class="client-item">
					<h3>Project: <?= $project['project_name'] ?></h3>
					<h4>Client: <a href="client.php?id=<?= $client['client_id'] ?>"><?= $client['client_name'] ?></a></h4>
					<p>Description:<br> <?= $project['project_other_details'] ?></p>
					<hr>
					<h4><strong>Dates:</strong></h4>
					<p>Start date: <?= $project['project_startdate'] ?></p>
					<p>End date: <?= $project['project_enddate'] ?></p>
				</div>

			</div>
		</div>
		<div class="edit-section">
			<p class="error"><a href="delete-project.php?id=<?= $_GET['id'] ?>">Delete project</a></p>
		</div>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
	</div>
</body>
</html>