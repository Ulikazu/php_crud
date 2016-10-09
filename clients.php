<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	} else {

		$sql_query = "SELECT * FROM clients";
		$records = $link->prepare($sql_query);
		$records->execute();
	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Clients - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Manage clients</h1>
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
		</div>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
	</div>
</body>
</html>