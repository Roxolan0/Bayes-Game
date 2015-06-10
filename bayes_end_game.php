<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes End Game</title>
	</head>

	<body>
		<?php
			session_start();

			function baseScore($value, $final)	//Calculates the score (-0.5 to 0.5) that comes from guessing correctly.
			{
				$valPAB = round(($_SESSION['valPBA']*$_SESSION['valPA']/$_SESSION['valPB']), 3);
				$baseScore = round(1.0 - abs($value - $valPAB), 2);
				if($baseScore >= 0.95) {		//A small margin of error (5%-) is tolerated.
					$baseScore = 1;
				} else if($baseScore <= 0.8) {	//A very large error (20%+) isn't. It's probably just a wild guess.
					$baseScore = 0;
				}
				$baseScore = $baseScore - 0.5;
				if($final == 1) {
					$baseScore = $baseScore * 10;
				}
				return $baseScore;
			}

			function timeModifier($duration)	//Bonus score (0 to 0.5) for guessing fast.
			{
				if($duration <= $_SESSION['timePenaltyImmunity']) {		//Up to X sec without penalties (depending on difficulty).
					$duration = 0;
				} else if($duration > $_SESSION['timePenaltyMax']) {	//No extra penalties beyond X sec (depending on difficulty).
					$duration = $_SESSION['timePenaltyMax'];
				}
				$timeModifier = ($_SESSION['timePenaltyMax'] - $duration)/$_SESSION['timePenaltyMax'] * 0.5;
				return $timeModifier;
			}

			function guessScore($duration, $value, $confidence, $final)		//Combining the different elements of the score into a whole.
			{
				$baseScore = baseScore($value, $final);
				if($final == 1) {
					$timeModifier = 0;
				} else {
					$timeModifier = timeModifier($duration);
				}
				$score = round(($baseScore * $confidence)  + $timeModifier, 2);
				return $score;
			}

			//Main code
			if(isset($_SESSION['valPBA']) && isset($_SESSION['valPA']) && isset($_SESSION['valPB'])
				&& isset($_SESSION['timePenaltyImmunity']) && isset($_SESSION['timePenaltyMax'])
				&& isset($_SESSION['gameid']) && isset($_SESSION['themeid']))
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));

				//Gathers and displays the answers.
				$valPAB = round(($_SESSION['valPBA']*$_SESSION['valPA']/$_SESSION['valPB']), 3);
				$query = "SELECT descPAB, descPBA, descPA, descPB
								FROM Themes
								WHERE themeId = " . $_SESSION['themeid'] . "
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$line = mysqli_fetch_assoc($result);

				echo "The game is over! <br \>
						<br \>
						P(A) = " . $line['descPA'] . " = " . 100*$_SESSION['valPA'] . "% <br \>
						P(B) = " . $line['descPB'] . " = " . 100*$_SESSION['valPB'] . "% <br \>
						P(B|A) = " . $line['descPBA'] . " = " . 100*$_SESSION['valPBA'] . "% <br \>
						<br \>
						P(A|B) = " . $line['descPAB'] . " = " . 100*$valPAB . "% <br \>
						<br \>
						";

				//Calculates and displays the score for each round of guessing.
				$query = "SELECT *
								FROM Guess
								WHERE gameId = " . $_SESSION['gameid'] . "
								ORDER BY turn
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));

				$totalScore = 0;
				$maxTotalScore = 0;
				$modifier = 100;
				$nbGuess = 1;
				$valPAB = round(($_SESSION['valPBA']*$_SESSION['valPA']/$_SESSION['valPB']), 3);
				while($guessLine = mysqli_fetch_assoc($result))
				{
					$turn = $guessLine['turn'];
					$duration = $guessLine['duration'];
					$value = $guessLine['value'];
					$confidence = $guessLine['confidence'];
					$final = $guessLine['final'];
					$baseScore = baseScore($value, $final);
					$timeModifier = timeModifier($duration);
					$guessScore = guessScore($duration, $value, $confidence, $final);
					$maxGuessScore = guessScore(0, $valPAB, 1, $final);
					if($final == 0)
					{
						echo "Guess " . $nbGuess;
					} else {
						echo "Final guess";
					}
					echo " (turn " . $turn . "): " . 100*$value . "% <br \>
							* Base score: " .$modifier*$baseScore . " <br \>
							* Confidence: " . 100*$confidence . "% <br \>";
					if($final == 0)
					{
						echo "* Time modifier: " . $modifier*$timeModifier . " (" . $duration . " sec) <br \>";
					}
						echo "*** Score: " . $modifier*$guessScore . " points <br \>
							<br \>
							";
					$nbGuess++;
					$totalScore = $totalScore + $guessScore;
					$maxTotalScore = $maxTotalScore + $maxGuessScore;
				}

				$percentScore = 100 * $totalScore / $maxTotalScore;

				echo "<br \>
						<br \>
						Total: " . $modifier*$totalScore . " points (with a hypothetical " . $modifier*$maxTotalScore . " points maximum) <br \>
						FINAL SCORE: " . round($percentScore) . "% <br \>
						";

				//Marks the game as finished in the database and stores the score.
				$query = "UPDATE Games
								SET finishedOn =  CURRENT_TIMESTAMP(),
									score = " . $totalScore . ",
									percentScore = " . $percentScore . ",
									finished = 1
								WHERE gameId = " . $_SESSION['gameid'] . "
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				echo "<p><a href=\"bayes_intro.php\">Back to intro page</a></p>";

				mysqli_close($link);
			}
			else	//An important SESSION or POST variable has not been set properly
			{
				header('Location: bayes_error.php');;
			}
		?>
	</body>
</html>
