<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes New Game</title>
	</head>
	
	<body>
		<?php
			session_start();
			if(isset($_POST['f_difficulty']) && isset($_SESSION['userid']))
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));
				
				//Destroys any previous ongoing games of this user (this cascades to destroy orphaned facts & guesses)
				$query = "DELETE FROM Games
								WHERE userId = " . $_SESSION['userid'] . "
								AND finished = 0;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				
				//Gathers difficulty variables
				$query = "SELECT nbTurns, nbGuesses
								FROM Difficulty
								WHERE difficultyId = " . $_POST['f_difficulty'] . "
								;";
				$result = mysqli_query($link, $query) or exit(mysqli_error($link));
				$line = mysqli_fetch_assoc($result);
				$nbTurns = $line['nbTurns'];		//Number of facts the player will get to research.
				$nbGuesses = $line['nbGuesses'];	//Number of times the game will ask for the player's guess.
				
				//Picks a random theme
				$query = "SELECT COUNT(*) AS nb_themes
								FROM Themes;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$nb_themes = mysqli_fetch_assoc($result)['nb_themes']; 
				$random_theme = mt_rand(1, $nb_themes);
				
				//Picks random values (between 0 and 1) for P(A), P(B) and P(B|A)
				$query = "SELECT RAND() AS random
								FROM ValueType
								LIMIT 0, 3
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$valPA = mysqli_fetch_assoc($result)['random'];
				$valPB = mysqli_fetch_assoc($result)['random'];
				$valPBA = $valPB * mysqli_fetch_assoc($result)['random'];	//P(B|A) <= P(B)

				//Adds the new game to the database
				$query = "INSERT INTO Games (
									userId, themeId, difficultyId,
									timeLeft, testsLeft, 
									valPBA, valPA, valPB
									)
								VALUES(
									" . $_SESSION['userid'] . ", $random_theme, " . $_POST['f_difficulty'] . ", 
									$nbTurns, $nbGuesses, 
									ROUND(" . $valPBA . ",3), ROUND(" . $valPA . ",3), ROUND(" . $valPB . ",3)
									)
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));

				mysqli_close($link);
				header('Location: bayes_continue_game.php');
			}
			else	//An important SESSION or POST variable has not been set properly
			{
				header('Location: bayes_error.php');;
			}
		?>
	</body>
</html>
