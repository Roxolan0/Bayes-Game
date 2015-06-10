<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes Game Guess Code</title>
	</head>

	<body>
		<?php
			session_start();
			$_SESSION['endClock'] = time();	//The clock is stopped as soon as possible.

            //Changed for the exam (moved from bayes_end_game.php)
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
				&& isset($_SESSION['gameid']) && isset($_SESSION['themeid'])
                && isset($_POST['f_guess']) && isset($_POST['f_confidence'])
				&& $_POST['f_guess'] >= 0 && $_POST['f_guess'] <= 100
				&& $_POST['f_confidence'] >= 0 && $_POST['f_confidence'] <= 100
				)
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));

				//Gathers data and adds a new guess in the database.
				$f_guess = $_POST["f_guess"]/100.0;
				$f_confidence = $_POST["f_confidence"]/100.0;
				$duration = $_SESSION['endClock'] - $_SESSION['startClock'];

				$query = "SELECT turn
								FROM Games
								WHERE gameId = " . $_SESSION['gameid'] . "
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$turn = mysqli_fetch_assoc($result)['turn'];

				//Changed for the exam.
                $score = guessScore($duration, $f_guess, $f_confidence, $_SESSION['final']);

				$query = "INSERT INTO Guess (gameId, turn, duration, value, confidence, final, score)
								VALUES(" . $_SESSION['gameid'] . ", "
										. $turn . ", "
										. $duration . ", "
										. $f_guess . ", "
										. $f_confidence . ", "
										. $_SESSION['final'] . ", "
										. $score . "
										);";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				mysqli_close($link);

				//Checks if the game is now over.
				if(!$_SESSION['final']) {
					header('Location: bayes_game_main.php');
				} else {
					header('Location: bayes_end_game.php');
				}
			}
			else	//An important SESSION or POST variable has not been set properly
			{
				header('Location: bayes_error.php');;
			}
		?>
	</body>
</html>
