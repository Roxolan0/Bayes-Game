<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes High Scores</title>
	</head>

	<body>
		<?php
			$link = mysqli_connect('localhost','bayes_player','');
			mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));
			$query = "SELECT gameId, username, Users.userId AS userId, DATE(finishedOn) AS finishedOn, percentScore
											FROM Games
											JOIN Users ON Games.userId = Users.userId
											WHERE finished = 1
											ORDER BY percentScore DESC, finishedOn DESC, username
											;";
			$result = mysqli_query($link, $query) or exit(mysqli_error($link));
			while($line = mysqli_fetch_assoc($result))
			{
				echo "<a href=\"bayes_view_game.php?gameId=" . $line['gameId'] . "\">"
							. $line['finishedOn'] . "</a>:
                            <a href=\"bayes_view_player.php?userId=" . $line['userId'] . "\">"
							. $line['username'] . "</a> (" . round($line['percentScore']) . "%)
						<br \>";
			}
			echo "<p><a href=\"bayes_intro.php\">Back to intro page</a></p>";
			mysqli_close($link);
		?>
	</body>
</html>
