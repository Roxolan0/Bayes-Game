<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes Register Code</title>
	</head>
	
	<body>
		<?php
			session_start();
			if (isset($_POST['f_username'])
				&& isset($_POST['f_password']) 
				&& isset($_POST['f_email']))
			{
				$f_username = $_POST["f_username"];
				$f_password = $_POST["f_password"];
				$f_email = $_POST["f_email"];

				//Checks if username is free
				$link = mysqli_connect("localhost","bayes_player","");
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));
				$result = mysqli_query($link, "SELECT username 
												FROM Users 
												WHERE username = '".$f_username."'
												") or exit(mysqli_error($link));
				if ($exists = mysqli_fetch_assoc($result))
				{
					echo "Username already taken. <br \>
							<br \>
							<p><a href=\"bayes_register.php\">Try again</a></p>
							<p><a href=\"bayes_intro.php\">Back to intro page</a></p>
						";
					mysqli_close($link);
				}
				else
				{
					$query = "INSERT INTO users (userid, username, password, email) 
									VALUES (DEFAULT, '$f_username','$f_password','$f_email')";
					$result = mysqli_query ($link,$query);
					echo "You have been registered! <br\>
						<br \>
							<p><a href=\"bayes_login.php\">Login</a></p>
							<p><a href=\"bayes_intro.php\">Back to intro page</a></p>
						";
				}
				mysqli_close($link);
			}
			else	//An important SESSION or POST variable has not been set properly
			{
				header('Location: bayes_error.php');;
			}
		?>
	</body>
</html>
