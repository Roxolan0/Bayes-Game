<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/bayes_style.css" />
		<title>Bayes View Player</title>
	</head>

	<body>
		<?php
            //Whole page added for exam.
			if(isset($_GET['userId']))
			{
				$link = mysqli_connect('localhost','bayes_player','');
				mysqli_query($link, 'USE bayes;') or exit(mysqli_error($link));

                $query = "SELECT *
                            FROM Users
                            WHERE userId = " . $_GET['userId'] . "
                            ;";
                $result = mysqli_query ($link,$query) or exit(mysqli_error($link));
				if($line = mysqli_fetch_assoc($result))
				{
                    $query = "SELECT gameId, DATE(createdOn) AS createdOn, DATE(finishedOn) AS finishedOn, percentScore
                                FROM Games
                                WHERE userId = " . $_GET['userId'] . "
                                    AND finished = 1
                                ORDER BY finishedOn DESC
                                ;";
                    $result = mysqli_query ($link,$query) or exit(mysqli_error($link));
                    while($line = mysqli_fetch_assoc($result))
                    {
                        echo "<a href=\"bayes_view_game.php?gameId=" . $line['gameId'] . "\">"
                                    . $line['finishedOn'] . "</a>: " . round($line['percentScore']) . "%
                                <br \>";
                    }
				}
                else	//playerId not in database
                {
                    echo "Error: player not found. <br \>";
                }
                mysqli_close($link);
            }
            else	//no valid playerId in the URL
            {
                echo "Error: no valid player id. <br \>";
            }
            echo "<br \>";
            echo "<p><a href=\"bayes_intro.php\">Back to the intro page</a></p>";
		?>
	</body>
</html>
