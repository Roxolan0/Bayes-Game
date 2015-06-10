<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Bayes Contine Game</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	
	<body>
		<?php
			session_start();

			if(isset($_SESSION['userid']))
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));

				$query = "SELECT *
								FROM Games
								JOIN Difficulty ON Games.difficultyId = Difficulty.difficultyId
								WHERE userId = " . $_SESSION['userid'] . "
								ORDER BY createdOn DESC;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$game = mysqli_fetch_assoc($result);
				$_SESSION['gameid'] = $game['gameId'];
				$_SESSION['themeid'] = $game['themeId'];
				$_SESSION['valPBA'] = $game['valPBA'];
				$_SESSION['valPA'] = $game['valPA'];
				$_SESSION['valPB'] = $game['valPB'];
				$_SESSION['final'] = 0;
				$_SESSION['timePenaltyImmunity'] = $game['timePenaltyImmunity'];
				$_SESSION['timePenaltyMax'] = $game['timePenaltyMax'];
				$_SESSION['noise'] = $game['noise'];
				
				mysqli_close($link);
				header('Location: bayes_game_main.php');
			}
			else	//An important SESSION or POST variable has not been set properly
			{
				header('Location: bayes_error.php');;
			}
		?>
	</body>
</html>