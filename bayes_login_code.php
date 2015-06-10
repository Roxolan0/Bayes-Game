<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes Login Code</title>
	</head>
	
	<body>
		<?php
			session_start();
			if (isset($_POST['f_username'])
				&& isset($_POST['f_password']))
			{
				//Checks that username & password match the database
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));
				$f_username = $_POST["f_username"];
				$f_password = $_POST["f_password"];
				$result = mysqli_query($link, "SELECT * 
									FROM Users 
									WHERE username = '".$f_username."' 
									AND password = '".$f_password."' 
									LIMIT 1
									;") or exit(mysqli_error($link));
				$check = mysqli_fetch_assoc($result);
				if($check)	//Valid login
				{
					$_SESSION['username'] = $f_username;
					$_SESSION['userid'] = $check['userId'];
					echo "You're logged in! <br \>
							<br \>
							<p><a href=\"bayes_intro.php\">Back to intro page</a></p>
						";
						mysqli_close($link);
						header('Location: bayes_intro.php');
				}
				else	//Non-valid login
				{		
					echo "Wrong username or password. <br \>
							<br \>
							<p><a href=\"bayes_login.php\">Try again</a></p>
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