<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes View Game</title>
	</head>
	
	<body>
		<?php
			if(isset($_GET['gameId']))
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));
				
				//General info
				$query = "SELECT *
								FROM Games
								JOIN Users ON Games.userId = Users.userId
								JOIN Difficulty ON Games.difficultyId = Difficulty.difficultyId
								JOIN Themes ON Games.themeId = Themes.themeId
								WHERE gameId = " . $_GET['gameId'] . "
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				if($line = mysqli_fetch_assoc($result))
				{
					echo "Game begun on " . $line['createdOn'] . "<br \>";
					if($line['finished'] == 1) {
						echo "Finished on " . $line['finishedOn'] . " (final score: " . round($line['percentScore']) . "%) <br \>";	//TODO display P(A), P(B), P(B|A), P(A|B)
					} else {
						echo "Still ongoing (" . $line['timeLeft'] . " turns left) <br \>";
					}
					echo "Difficulty: " . $line['name'] . "<br \>
							Player: " . $line['username'] . "<br \>
							<br \>
							";
					
					//Answers
					if($line['finished'] == 1) 
					{
						$valPAB = round(($line['valPBA']*$line['valPA']/$line['valPB']), 3);
						echo $line['descPA'] . " = " . 100*$line['valPA'] . "% <br \>
								" . $line['descPB'] . " = " . 100*$line['valPB'] . "% <br \>
								" . $line['descPBA'] . " = " . 100*$line['valPBA'] . "% <br \>
								<br \>
								" . $line['descPAB'] . " = " . 100*$valPAB . "% <br \>
								<br \>
								";
					}
					
					//Facts acquired and guesses made, by turn order
					$curTurn = $line['turn'];
					if($line['finished'] == 1) {
						$curTurn++;
					}
					for($i = 1; $i < $curTurn; $i++)
					{
						echo "Turn " . $i . ": ";
						$query = "SELECT * FROM Facts
										JOIN FactTemplates ON Facts.templateId = FactTemplates.templateId
										WHERE gameId = " . $_GET['gameId'] . "
										AND turn = " . $i . "
										;";
						$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
						if($line = mysqli_fetch_assoc($result))
						{
							echo "Fact: \"" . $line['textBefore'] . $line['value'] . $line['textAfter'] . "\" <br \>";
						}
						else
						{
							$query = "SELECT * FROM Guess
											WHERE gameId = " . $_GET['gameId'] . "
											AND turn = " . $i . "
											;";
							$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
							$line = mysqli_fetch_assoc($result);
							echo "Guess: " . $line['value'] . "
									with " . 100*$line['confidence'] . "% confidence 
									(in " . $line['duration'] . " seconds) <br \>";
						}
					}
				}
				else	//gameId not in database
				{
					echo "Error: game not found. <br \>";
				}
				mysqli_close($link);
			}
			else	//no valid gameId in the URL
			{
				echo "Error: no valid game id. <br \>";
			}
			echo "<br \>";
			echo "<p><a href=\"bayes_intro.php\">Back to the intro page</a></p>";
		?>
	</body>
</html>
