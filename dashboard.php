<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	} else {

		$sql_query = "SELECT * FROM clients";
		$records = $link->prepare($sql_query);
		$records->execute();

		$projectsquery = "SELECT * FROM projects";
		$projectrecords = $link->prepare($projectsquery);
		$projectrecords->execute();

	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Welcome to your dashboard!</h1>
		<p>What would you like to do today?</p>
		<div class="action-options">
			<a href="new-client.php"><p>Register a new client</p></a>
			<a href="clients.php"><p>Manage clients</p></a>
			<a href="new-project.php"><p>Start a new project</p></a>
			<a href="projects.php"><p>Manage projects</p></a>
		</div>
		<div class="list-section">
			<div class="clients-section">
				<h2>Clients</h2>
				<?php 

				while ($client = $records->fetch(PDO::FETCH_ASSOC)) {
					?>
					<div class="client-item">
						<h3><a href="client.php?id=<?= $client['client_id'] ?>"><?= $client['client_name'] ?></a></h3>
						<p>Contact: <?= $client['client_contact_name'] ?></p>
					</div>
					<?php
				}


				 ?>
			</div>
			<div class="project-section">
				<h2>Projects</h2>

				<?php 

				while ($project = $projectrecords->fetch(PDO::FETCH_ASSOC)) {
					?>
					<div class="client-item">
						<h4><a href="project.php?id=<?= $project['project_id'] ?>"><?= $project['project_name'] ?></a></h4>
					</div>
					<?php
				}?>
			</div>
		</div>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
	</div>
</body>
</html>