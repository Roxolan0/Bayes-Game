<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes Game Guess</title>
	</head>

	<body>
		<?php
			session_start();

			if(isset($_SESSION['final']) && isset($_SESSION['themeid']) && isset($_SESSION['gameid']))
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));

				echo "<figure><img src=\"images/bayes_equation.png\" alt=\"Bayes' Theorem Equation\" /></figure>";
				if(!$_SESSION['final'])
				{
					echo "<p>Time to make a guess! </p>";
				} else {
					echo "<p>FINAL guess! </p>";
				}

				//Finds text description of the thinge that must be guessed.
				$query = "SELECT descPAB
								FROM Themes
								WHERE themeId = " . $_SESSION['themeid'] . "
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$goal = mysqli_fetch_assoc($result)['descPAB'];

				//List of facts
				echo "<h2>Known facts: </h2>";
				$query = "SELECT Games.gameId, Facts.turn, value, textBefore, textAfter
								FROM Games
								JOIN Facts ON Games.gameId = Facts.gameId
								JOIN FactTemplates ON Facts.templateId = FactTemplates.templateId
								WHERE Games.gameId = " . $_SESSION['gameid'] . "
								ORDER BY Facts.turn, textBefore, textAfter, value;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$i = 1;
				echo "<ol>";
				while($line = mysqli_fetch_assoc($result))
				{
					$percentValue = $line['value'] * 100;
					$percentValue = round($percentValue, 1);
					echo "<li>\"" . $line['textBefore'] . $percentValue . "%" . $line['textAfter'] . "\" </li>";
					$i++;
				}
				echo "</ol>";

				//Explanations
				echo "	<p>Enter your best guess for <em>" . $goal . "</em>. <br \>
				A high confidence will earn you more points if you're right but will cost you more points if you're wrong.</p>";
				if(!$_SESSION['final'])
				{
					echo "<p><strong>Warning : you're being timed!</strong> The longer you take, the less points you gain!</p>";
				} else {
					echo "<p>Don't worry, no time pressure this time. Take as long as you need.<br \>
							Be careful though. Your final guess is worth a lot more points than the previous ones.</p>" ;
				}

				//Answers form
				echo "<form method=\"POST\" action=\"bayes_game_guess_code.php\">
					<table>
					<tr><td> Your guess: </td> <td><input type=\"number\" min=\"0\" max=\"100\" name=\"f_guess\"> % </td></tr>
					<tr><td> Confidence level: </td> <td><input type=\"number\" min=\"0\" max=\"100\" name=\"f_confidence\"> % </td></tr>
					<tr><td><input type=\"submit\" name=\"f_submi\" value=\"Submit\"></td></tr>
					</table>
					</form>
					";

				echo "<p><a href=\"bayes_intro.php\">Back to intro page</a></p>";
				mysqli_close($link);

				//The timer starts after everything else on the page is loaded.
				$_SESSION['startClock'] = time();
			}
			else	//An important SESSION or POST variable has not been set properly
			{
				header('Location: bayes_error.php');;
			}
		?>
	</body>
</html>
