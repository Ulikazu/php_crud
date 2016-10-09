<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	} else {
		// print_r($_SESSION);

		if (!empty($_POST['submit'])) {

			$project_name = $_POST['project_name'];
			$project_other_details = $_POST['project_details'];
			$project_startdate = $_POST['project_startdate'];
			$project_enddate = $_POST['project_enddate'];
			$client_id = $_POST['client'];
			
			$sql_query = "INSERT INTO projects (project_name, project_other_details, project_startdate, project_enddate, clients_client_id) VALUES (:projectname, :projectotherdetails, :projectstartdate, :projectenddate, :clientsclientid)";
			$statement = $link->prepare($sql_query);
			$statement->bindParam(':projectname', $project_name, PDO::PARAM_STR);
			$statement->bindParam(':projectotherdetails', $project_other_details, PDO::PARAM_STR);
			$statement->bindParam(':projectstartdate', $project_startdate, PDO::PARAM_STR);
			$statement->bindParam(':projectenddate', $project_enddate, PDO::PARAM_STR);
			$statement->bindParam(':clientsclientid', $client_id, PDO::PARAM_INT);

			if ($statement->execute()) {
				$lastproject = $link->lastInsertId();
				header("Location: project.php?id=$lastproject");
			} else {
				echo "Something went wrong...". print_r($statement->errorInfo());
			}
		}

		$client_query = "SELECT * FROM clients";
		$clientstatement = $link->prepare($client_query);
		$clientstatement->execute();
	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>New Project - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Start a new project</h1>
		<div class="action-options">
			<a href="new-client.php"><p>Register a new client</p></a>
			<a href="clients.php"><p>Manage clients</p></a>
			<a href="new-project.php"><p>Start a new project</p></a>
			<a href="projects.php"><p>Manage projects</p></a>
		</div>
		<p>From here you can start a new project. Make sure you have <a href="new-client.php">registered the client</a> for this project beforehand.</p>
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<input type="text" name="project_name" placeholder="Title" required>
			<textarea name="project_details" required></textarea>
			<label>Start date:</label>
			<input type="date" name="project_startdate" required>
			<label>End date:</label>
			<input type="date" name="project_enddate" required>
			Client:
			<select name="client" required>
				<?php 

				while ($client = $clientstatement->fetch(PDO::FETCH_ASSOC)) {
					?>

					<option value="<?= $client['client_id'] ?>"><?= $client['client_id'].' - '.$client['client_name'] ?></option>

					<?php
				}

				 ?>
			</select>
			<input type="submit" name="submit" value="Start project">
		</form>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
	</div>
</body>
</html>