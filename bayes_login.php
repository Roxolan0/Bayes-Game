<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes Login</title>
	</head>
	
	<body>
		<?php
			session_start();
			if(!isset($_SESSION['userid']) || !isset($_SESSION['username']))
			{
				echo "
					<form method=\"POST\" action=\"bayes_login_code.php\">
					<h2>Login: </h2>
					
					<table>
					<tr><td> Username : </td> <td><input type=\"text\" name=\"f_username\"></td></tr>
					<tr><td> Password   : </td> <td><input type=\"password\" name=\"f_password\"></td></tr>
					<tr><td><input type=\"submit\" name=\"f_submi\" value=\"Submit\"></td></tr>
					</table>
					</form>
					";
			}
			else
			{
				echo "You're already logged in!";
				echo "<p><a href=\"bayes_intro.php\">Back to intro page</a></p>";
			}
		?>
	</body>
</html>