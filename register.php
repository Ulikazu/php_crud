<?php
	include 'dbconst.php';


	session_start();

	if (isset($_POST['email']) && isset($_POST['password'])) {
		
		$userEmail = $_POST['email'];
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		
		$sql_query = "INSERT INTO users (email, hashed_pass) VALUES (:email, :password)";
		$statement = $link->prepare($sql_query);
		$statement->bindParam(':email', $userEmail, PDO::PARAM_STR);
		$statement->bindParam(':password', $password, PDO::PARAM_STR);
		
		if ($statement->execute()) {
			$message = "Successfully registered new user! You can start <a href='login.php'>logging in now!</a>";
		} else {
			$message = "Sorry, there must have been an issue creating an account, check with the system administrator.";
		}

	}
	

?>			

<!DOCTYPE html>
<html>
<head>
	<title>Dashy - Sign up</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Register for an account to access the dashboard</h1>

		<?= !empty($message) ? "<p class='message'>$message</p>" : '' ?>

		<form action="register.php" method="post" class="form">
			<input type="email" name="email" placeholder="Email" required>
			<!-- <p onclick="toggleVisiblePassword()">Show password</p> -->
			<input type="password" name="password" placeholder="Password" required>
			<input type="submit" value="Sign up" name="submit">
		</form>
	</div>
</body>
</html>