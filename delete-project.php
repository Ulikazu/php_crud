<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	} else {

		if (isset($_GET['id'])) {

			if (isset($_POST['delete'])) {
				
				$deletequery = "DELETE FROM projects WHERE project_id = :projectid";
				$deletestatement = $link->prepare($deletequery);
				$deletestatement->bindParam(':projectid', $_GET['id'], PDO::PARAM_INT);

				if ($deletestatement->execute()) {
					header("Location: clients.php");
				} else {
					print_r($deletestatement->errorInfo());
				}

			}
			
			$sql_query = "SELECT * FROM projects WHERE project_id = :projectid";
			$records = $link->prepare($sql_query);
			$records->bindParam(':projectid', $_GET['id'], PDO::PARAM_INT);
			$records->execute();
			$project = $records->fetch(PDO::FETCH_ASSOC);

			if (count($project) > 0) {
				
				$clientquery = "SELECT * FROM clients WHERE client_id = :clientid";
				$clientstatement = $link->prepare($clientquery);
				$clientstatement->bindParam(":clientid", $project['clients_client_id']);
				$clientstatement->execute();

				$client = $clientstatement->fetch(PDO::FETCH_ASSOC);
			} else {
				header("Location: projects.php");
			}
			

		} else {
			header("Location: projects.php");
		}

	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Delete project - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>You are about to delete the following project:</h1>
		<p><?= $project['project_id'].' - '.$project['project_name'] ?>. <br> Note that this will not delete the client, <?= $client['client_name'] ?>, attached to the project, only the project itself.</p>
		<p>Not what you wanted to do? <a href="project.php?id=<?= $_GET['id'] ?>">Go back.</a></p>
		<form action="<?= $_SERVER['PHP_SELF'].'?id='.$_GET['id'] ?>" method="post">
			<input type="submit" value="Delete" name="delete">
		</form>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
	</div>
</body>
</html>