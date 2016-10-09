<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	} else {

		$sql_query = "SELECT clients.client_id, clients.client_name, projects.project_id, projects.project_name
						FROM clients
						INNER JOIN projects
						ON clients.client_id = projects.clients_client_id
						ORDER BY projects.project_id DESC";
		$records = $link->prepare($sql_query);
		$records->execute();
	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Projects - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Manage projects</h1>
		<div class="action-options">
			<a href="new-client.php"><p>Register a new client</p></a>
			<a href="clients.php"><p>Manage clients</p></a>
			<a href="new-project.php"><p>Start a new project</p></a>
			<a href="projects.php"><p>Manage projects</p></a>
		</div>
		<div class="list-section">
			<div class="clients-section">
				<h2>Projects</h2>
				<?php 

				while ($project = $records->fetch(PDO::FETCH_ASSOC)) {
					?>
					<div class="client-item">
						<h3><a href="project.php?id=<?= $project['project_id'] ?>"><?= $project['project_name'] ?></a></h3>
						<p>Client: <a href="client.php?id=<?= $project['client_id'] ?>"><?= $project['client_name'] ?></a></p>
					</div>
					<?php
				}


				 ?>
			</div>
		</div>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
	</div>
</body>
</html>