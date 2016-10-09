<?php
	
	session_start();

	include "dbconst.php";

	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	} else {
		if (isset($_POST['delete'])) {
			
			$deletequery = "DELETE FROM clients WHERE client_id = :clientid";
			$deletestatement = $link->prepare($deletequery);
			$deletestatement->bindParam(':clientid', $_GET['id'], PDO::PARAM_INT);

			if ($deletestatement->execute()) {
				header("Location: clients.php");
			} else {
				print_r($deletestatement->errorInfo());
			}

		}
		
		$sql_query = "SELECT * FROM clients WHERE client_id = :clientid";
		$records = $link->prepare($sql_query);
		$records->bindParam(':clientid', $_GET['id'], PDO::PARAM_INT);
		$records->execute();
		$client = $records->fetch(PDO::FETCH_ASSOC);

		if (count($client) > 0) {
			$projectsquery = "SELECT * FROM projects WHERE clients_client_id = :clientid";
			$projectstatement = $link->prepare($projectsquery);
			$projectstatement->bindParam(':clientid', $_GET['id'], PDO::PARAM_INT);
			$projectstatement->execute();
		}

	}

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Delete client - Dashy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>You are about to delete the following client:</h1>
		<p><?= $client['client_id'].' - '.$client['client_name'] ?>. <br> Note that this will also delete the following projects associated with the client:</p>
		<ul>
		<?php 

			while ($project = $projectstatement->fetch(PDO::FETCH_ASSOC)) {
				?>
	
				<li><a href="project.php?id=<?= $project['project_id'] ?>"><?= $project['project_name'] ?></a></li>

				<?php
			}

		 ?>
		</ul>
		<p>Not what you wanted to do? <a href="client.php?id=<?= $_GET['id'] ?>">Go back.</a></p>
		<form action="<?= $_SERVER['PHP_SELF'].'?id='.$_GET['id'] ?>" method="post">
			<input type="submit" value="Delete" name="delete">
		</form>
		<p>Need an adult or wanna leave? <a href="logout.php">Log out here</a></p>
	</div>
</body>
</html>