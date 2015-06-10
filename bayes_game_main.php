<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes Game Main</title>
	</head>

	<body>
		<?php
			session_start();

			function getValue($valueTypeId)		//Retrieves or computes the true value of various probabilities
			{
				if($valueTypeId == 1) {
					$result = $_SESSION['valPA'];
				} else if($valueTypeId == 2) {
					$result = $_SESSION['valPB'];
				} else if($valueTypeId == 3) {
					$result = $_SESSION['valPBA'];
				} else if($valueTypeId == 4) {
					$result = 1 - $_SESSION['valPA'];
				} else if($valueTypeId == 5) {
					$result = 1 - $_SESSION['valPB'];
				} else if($valueTypeId == 6) {
					$result = 1 - $_SESSION['valPBA'];
				} else if($valueTypeId == 7) {
					$result = ($_SESSION['valPB'] - $_SESSION['valPA']*$_SESSION['valPBA'])/(1-$_SESSION['valPA']);
				} else if($valueTypeId == 8) {
					$result = ($_SESSION['valPB'] - $_SESSION['valPA']*$_SESSION['valPBA'])/(1-$_SESSION['valPA']);
					$result = 1 -  $result;
				} else if($valueTypeId == 9) {
					$result = (1 - $_SESSION['valPBA']) * $_SESSION['valPA']/(1-$_SESSION['valPB']);
				} else {
					$result = (1 - $_SESSION['valPBA']) * $_SESSION['valPA']/(1-$_SESSION['valPB']);
					$result = 1 - $result;
				}
				return $result;
			}

			function randomValueTypeId($focus)	//Generates a random valueType that's relevant to the player's research focus.
												//Weighted in favour of the valueTypes that will require the least amount of math from the player.
			{
				if($focus == 'A')	//Direct: 1,3,6; Indirect:	9
				{
					$vtid[1] = 34;
					$vtid[2] = 0;
					$vtid[3] = 34;
					$vtid[4] = 0;
					$vtid[5] = 0;
					$vtid[6] = 20;
					$vtid[7] = 0;
					$vtid[8] = 0;
					$vtid[9] = 12;
					$vtid[10] = 0;
				}
				else if($focus == 'NA') //Direct: 4,7,8; Indirect:	10
				{
					$vtid[1] = 0;
					$vtid[2] = 0;
					$vtid[3] = 0;
					$vtid[4] = 28;
					$vtid[5] = 0;
					$vtid[6] = 0;
					$vtid[7] = 32;
					$vtid[8] = 27;
					$vtid[9] = 0;
					$vtid[10] = 13;
				}
				else if($focus == 'B')	//Direct: 2; Indirect:	3,7
				{
					$vtid[1] = 0;
					$vtid[2] = 60;
					$vtid[3] = 25;
					$vtid[4] = 0;
					$vtid[5] = 0;
					$vtid[6] = 0;
					$vtid[7] = 15;
					$vtid[8] = 0;
					$vtid[9] = 0;
					$vtid[10] = 0;
				}
				else if($focus == 'NB')	//Direct: 5,9,10; Indirect:	6,8
				{
					$vtid[1] = 0;
					$vtid[2] = 0;
					$vtid[3] = 0;
					$vtid[4] = 0;
					$vtid[5] = 26;
					$vtid[6] = 14;
					$vtid[7] = 0;
					$vtid[8] = 13;
					$vtid[9] = 24;
					$vtid[10] = 23;
				}
				else	//No focus
				{
					$vtid[1] = 20;
					$vtid[2] = 20;
					$vtid[3] = 20;
					$vtid[4] = 6;
					$vtid[5] = 6;
					$vtid[6] = 6;
					$vtid[7] = 10;
					$vtid[8] = 5;
					$vtid[9] = 4;
					$vtid[10] = 3;
				}

				$roll = mt_rand(1,100);
				if($roll <= $vtid[1]) {
					$result = 1;
				} else if($roll <= $vtid[1]+$vtid[2]) {
					$result = 2;
				} else if($roll <= $vtid[1]+$vtid[2]+$vtid[3]) {
					$result = 3;
				} else if($roll <= $vtid[1]+$vtid[2]+$vtid[3]+$vtid[4]) {
					$result = 4;
				} else if($roll <= $vtid[1]+$vtid[2]+$vtid[3]+$vtid[4]+$vtid[5]) {
					$result = 5;
				} else if($roll <= $vtid[1]+$vtid[2]+$vtid[3]+$vtid[4]+$vtid[5]+$vtid[6]) {
					$result = 6;
				} else if($roll <= $vtid[1]+$vtid[2]+$vtid[3]+$vtid[4]+$vtid[5]+$vtid[6]+$vtid[7]) {
					$result = 7;
				} else if($roll <= $vtid[1]+$vtid[2]+$vtid[3]+$vtid[4]+$vtid[5]+$vtid[6]+$vtid[7]+$vtid[8]) {
					$result = 8;
				} else if($roll <= $vtid[1]+$vtid[2]+$vtid[3]+$vtid[4]+$vtid[5]+$vtid[6]+$vtid[7]+$vtid[8]+$vtid[9]) {
					$result = 9;
				} else {
					$result = 10;
				}
				return $result;
			}

			function randomTemplateId($themeId, $valueTypeId)	//Generates a random templateId that fits a theme and valueType
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));
				$query = "SELECT templateId
								FROM FactTemplates
								WHERE themeId = " . $themeId . "
								AND valueTypeId = " . $valueTypeId . "
								ORDER BY RAND()
								LIMIT 1
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$templateId = mysqli_fetch_assoc($result)['templateId'];
				mysqli_close($link);
				return $templateId;
			}

			function randomlyAlteredValue($valueTypeId)	//Adds random noise (amount based on difficulty) to the true value of a valueType.
			{
				$realValue = getValue($valueTypeId);
				$link = mysqli_connect('localhost','bayes_player','');

				//Average between two normal [0,1] distributions, spread over a domain that depends on the difficulty.
				$query = "SELECT RAND() AS random;";
				$result = mysqli_query($link, $query) or exit(mysqli_error($link));
				$noise = mysqli_fetch_assoc($result)['random'];
				$result = mysqli_query($link, $query) or exit(mysqli_error($link));
				$noise = $noise + mysqli_fetch_assoc($result)['random'];
				$noise = ($noise * $_SESSION['noise'])/2;

				//Improves appearance removes risks of divide-by-zero errors.
				$alteredValue = round($realValue + $noise, 3);
				if($alteredValue >= 1)
				{
					$alteredValue = 0.999;
				} else if($alteredValue <= 0)
				{
					$alteredValue = 0.001;
				}

				mysqli_close($link);
				return $alteredValue;
			}

			function addRandomFact($valueTypeId)	//Creates a random fact about a specific valueType and adds it to the database.
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));

				$query = "SELECT turn
								FROM Games
								WHERE gameId = " . $_SESSION['gameid'] . "
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$turn = mysqli_fetch_assoc($result)['turn'];

				$random_templateId = randomTemplateId($_SESSION['themeid'], $valueTypeId);
				$random_value = randomlyAlteredValue($valueTypeId);
				$query = "INSERT INTO Facts (gameId, templateId, turn, value)
								VALUES(" . $_SESSION['gameid'] . ", "
										. $random_templateId . ", "
										. $turn . ", "
										. $random_value . ");";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				mysqli_close($link);
			}

            //Added for the exam.
            function addKeywordFact($keyword)
            {
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));

				$query = "SELECT templateId
                                FROM FactTemplates
                                WHERE themeId = " . $_SESSION['themeid'] . "
                                AND textBefore LIKE '%" . $keyword . "%'
                                ;";
                echo $query;//TODO remove
                echo "<br \>";
                $line = mysqli_fetch_assoc($result);
                echo $line;
                if($line = mysqli_fetch_assoc($result))
                {
                    echo "Keyword found! <br \>";
//                    $query = "SELECT turn
//                                    FROM Games
//                                    WHERE gameId = " . $_SESSION['gameid'] . "
//                                    ;";
//                    $result = mysqli_query ($link,$query) or exit(mysqli_error($link));
//                    $turn = mysqli_fetch_assoc($result)['turn'];
//
//                    $random_templateId = randomTemplateId($_SESSION['themeid'], $valueTypeId);
//                    $random_value = randomlyAlteredValue($valueTypeId);
//                    $query = "INSERT INTO Facts (gameId, templateId, turn, value)
//                                    VALUES(" . $_SESSION['gameid'] . ", "
//                                            . $random_templateId . ", "
//                                            . $turn . ", "
//                                            . $random_value . ");";
//                    $result = mysqli_query ($link,$query) or exit(mysqli_error($link));
                    addRandomFact(1);   //TODO remove
                }
                else
                {
                    echo "Keyword not found! Random fact instead. <br \>";
                    addRandomFact(1);
                }
				mysqli_close($link);
            }

			//Main code
			if(isset($_SESSION['valPA']) && isset($_SESSION['valPB']) && isset($_SESSION['valPBA'])
				&& isset($_SESSION['noise']) && isset($_SESSION['gameid']) && isset($_SESSION['themeid'])
				&& isset($_SESSION['final'])
				)
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));

				if(isset($_POST['f_focus']) && isset($_POST['f_keyword']))	//The page re-loaded after the player ordered a new fact.
				{
                    if($_POST['f_keyword'] != "")
                    {
                        addKeywordFact($_POST['f_keyword']);
                    } else {
                        addRandomFact(randomValueTypeId($_POST['f_focus']));
                    }
					$query = "UPDATE Games
									SET timeLeft = timeLeft - 1
									WHERE gameId = " . $_SESSION['gameid'] . "
									;";
					$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
					unset($_POST['f_focus']);
					unset($_POST['f_keyword']);

					//Random check to see if it's time to ask the player to make a guess.
					$query = "SELECT turn, timeLeft, testsLeft
									FROM Games
									WHERE gameId = " . $_SESSION['gameid'] . "
									;";
					$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
					$line = mysqli_fetch_assoc($result);
					if($line['turn'] >= 2				//It'd be unfair to ask for a guess when the player knows less than two facts.
						&& $line['testsLeft'] > 0		//The amount of guesses per game depends on difficulty.
						&& mt_rand($line['testsLeft'],$line['timeLeft']) == $line['timeLeft'])
						//Will become more and more likely over time, and will always perform exactly the right amount of guesses per game.
					{
						$query = "UPDATE Games
										SET testsLeft = testsLeft - 1
										WHERE gameId = " . $_SESSION['gameid'] . "
										;";
						$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
						mysqli_close($link);
						header('Location: bayes_game_guess.php');
					}
				}

				//Increments turn counter
				$query = "UPDATE Games
								SET turn = turn + 1
								WHERE gameId = " . $_SESSION['gameid'] . "
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));

				//Checks if it's time for the final guess
				$query = "SELECT timeLeft
								FROM Games
								WHERE gameId = " . $_SESSION['gameid'] . "
								;";
				$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				$timeleft = mysqli_fetch_assoc($result)['timeLeft'];
				if($timeleft <= 0)
				{
					$_SESSION['final'] = 1;
					mysqli_close($link);
					header('Location: bayes_game_guess.php');
				}
				else	//Regular turn
				{

                    echo "<figure><img src=\"images/bayes_equation.png\" alt=\"Bayes' Theorem Equation\" /></figure>";

                    //Changed for the exam.
                    $query = "SELECT AVG(confidence) AS avgConf, AVG(score) AS avgScore
                                    FROM Guess
                                    WHERE gameId = " . $_SESSION['gameid'] . "
                                    ;";
                    $result = mysqli_query ($link,$query) or exit(mysqli_error($link));
                    $line = mysqli_fetch_assoc($result);
                    $avgConfidence = round(100 * $line['avgConf'], 1);
                    $avgScore = round(100 * $line['avgScore'], 1);
                    echo "<p>Your progress so far: <br \>
                        <em>Average confidence rating: </em> " . $avgConfidence . "% <br \>
                        <em>Average score: </em> " . $avgScore. "% <br \>
                        </p>";

					echo "<p>You have time to research " . $timeleft . " more facts. </p>
						<br \>
						Known facts: <br \>
						<br \>
						";

					//List of facts
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

					//Menu
					$query = "SELECT descA, descNA, descB, descNB
									FROM Themes
									WHERE themeId = " . $_SESSION['themeid'] . "
									;";
					$result = mysqli_query ($link,$query) or exit(mysqli_error($link));
					$line = mysqli_fetch_assoc($result);

					//Changed for the exam:
					echo "<form method=\"POST\" action=\"bayes_game_main.php\">
						<tr><td> Focus research on: </td> <td><select name=\"f_focus\">
							<option selected value=\"any\">nothing in particular</option>
							<option value=\"A\">" . $line['descA'] . "</option>
							<option value=\"NA\">" . $line['descNA'] . "</option>
							<option value=\"B\">" . $line['descB'] . "</option>
							<option value=\"NB\">" . $line['descNB'] . "</option>
						</select></td></tr>
						<br \> OR use a keyword: <input type=\"text\" name=\"f_keyword\">
                        <br \>
						<tr><td><input type=\"submit\" name=\"f_buyFact\" value=\"Research\"></td></tr>
						</table>
						</form>
						";
					}

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
