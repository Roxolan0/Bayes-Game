<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes Register</title>
	</head>
	
	<body>
		<?php
			echo "
				<form method=\"POST\" action=\"bayes_register_code.php\">
				<h2>Register: </h2>
				
				<table>
				<tr><td> Username : </td> <td><input type=\"text\" name=\"f_username\"></td></tr>
				<tr><td> Password   : </td> <td><input type=\"password\" name=\"f_password\"></td></tr>
				<tr><td> Email  : </td> <td><input type=\"email\" name=\"f_email\"></td></tr>
				<tr><td><input type=\"submit\" name=\"f_submi\" value=\"Submit\"></td></tr>
				</table>
				</form>
				";
			echo "<p><a href=\"bayes_intro.php\">Back to the intro page</a></p>";
		?>
	</body>
</html>