<?php
	
	session_start();
	
	include 'dbconst.php';

	if (isset($_SESSION['user_id'])) {
		header("Location: dashboard.php?user=".$_SESSION['user_id']);
	}

	if (isset($_POST['email']) && isset($_POST['password'])) {

		$user_email = $_POST['email'];
		$password = $_POST['password'];

		$sql_query = "SELECT user_id, email, hashed_pass FROM users WHERE email = :email";
		$records = $link->prepare($sql_query);
		$records->bindParam(':email', $user_email, PDO::PARAM_STR);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);

		if (count($results) > 0 && password_verify($password, $results['hashed_pass'])) {
			$_SESSION['user_id'] = $results['user_id'];
			header("Location: dashboard.php?user=".$results['user_id']);
		} else {
			$message = "<p class='error'>Sorry, nobody is registered with those credentials.</p>";
		}
	
	}
	
	

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Dashy - Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Please log in to access the dashboard</h1>

		<?= $message ? $message : '' ?>

		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="form">
			<input type="email" name="email" placeholder="Email" required>
			<input type="password" name="password" placeholder="Password" required>
			<input type="submit" value="Sign in" name="submit">
		</form>
	</div>
</body>
</html>