<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes Intro</title>
	</head>

	<body>
		<?php
			session_start();

			echo "<h1>The Bayesian Conspiracy</h1>";

			//List of latest games
			$score_table_size = 5;
			echo "<h2>Latest games:</h2>
					<p class=\"latest_games\">";
			$link = mysqli_connect('localhost','bayes_player','');
			mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));
			$query = "SELECT Users.userId AS userId, gameId, username, finishedOn, percentScore
											FROM Games
											JOIN Users ON Games.userId = Users.userId
											WHERE finished = 1
											ORDER BY finishedOn DESC, username
											LIMIT 0, " . $score_table_size .
											";";
			$result = mysqli_query($link, $query) or exit(mysqli_error($link));
			while($line = mysqli_fetch_assoc($result))
			{
				echo "      <a href=\"bayes_view_game.php?gameId=" . $line['gameId'] . "\">"
							. $line['finishedOn'] . "</a>:
							<a href=\"bayes_view_player.php?userId=" . $line['userId'] . "\">"
							. $line['username'] . "</a>
							(" . round($line['percentScore']) . "%)
						<br \>";
			}

			echo "</p>
					<p>Welcome, <strong>";
			if(!isset($_SESSION['username'])) {	//not logged in
				echo "newcomer";
			} else {	//logged in
				echo $_SESSION['username'];
			}
			echo "</strong>. </p>";

			//Menu
			echo "<ul>";
			if(!isset($_SESSION['username']))	//not logged in
			{
				echo "
						<li><a href=\"bayes_login.php\">Login</a></li>
						<li><a href=\"bayes_register.php\">Register</a></li>
						";
			}
			if(isset($_SESSION['username']))	//logged in
			{
				echo "<li><form method=\"POST\" action=\"bayes_new_game.php\">
						<input type=\"submit\" name=\"f_newGame\" value=\"New game\">
							 (difficulty: <select name=\"f_difficulty\">
						";
				$query = "SELECT difficultyId, difOrder, name
								FROM Difficulty
								ORDER BY difOrder
								;";
				$result = mysqli_query($link, $query) or exit(mysqli_error($link));
				while($line = mysqli_fetch_assoc($result))
				{
					echo "<option ";
					if($line['name'] == "normal") {
						echo "selected ";
					}
					echo "value=\"$line[difficultyId]\">$line[name]</option>";
				}
				echo "</select>)
						</form></li>
						";
				$query = "SELECT gameId
								FROM Games
								WHERE userId = " . $_SESSION['userid'] . "
								AND finished = 0
								;";
				$result = mysqli_query($link, $query) or exit(mysqli_error($link));
				if($line = mysqli_fetch_assoc($result)) {	//There is an ongoing game
					echo "<li><a href=\"bayes_continue_game.php\">Continue game</a></li>";
				}
				echo "<li><a href=\"bayes_high_scores.php\">High scores</a></li>";
				echo "<li><a href=\"bayes_help.php\">Help</a></li>";
				echo "<li><a href=\"bayes_logout.php\">Log out</a></li>";
				echo "</ul>";
			}
			mysqli_close($link);
		?>
	</body>
</html>
