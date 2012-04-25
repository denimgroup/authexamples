<?php
    session_start();

	//	If the user is logged in they shouldn't see this page.
	//	Bounce them back to the index

    if(isset($_SESSION["user_data"])) {
		header("Location: /index.php");
		exit;
    } else {
		//	Buffer so we can do all the logic stuff we want and then optionall
		//	send redirects when finished
		ob_start();
	}
?>
<?php
	//	Set up some page data
	$second_stage_questions[0] = array( '1234', 'What is your favorite fruit', 'apple' );
	$second_stage_questions[1] = array( '817', 'What is your favorite Jobs job', 'apple' );
	$second_stage_questions[2] = array( '423', 'What is your favorite Beatles record label', 'apple' );

	function render_login_stuff()
	{
		echo("Hint: username=testuser and password=password might work<br />");
		echo("Username: <input name='username' /><br />");
		echo("Password: <input name='password' type='password' /><br>");
		echo("<input type='submit' value='Log In' />");
	}

	function render_second_stage($my_questions)
	{
		$num_questions = count($my_questions);
		$question_index = rand(0, $num_questions - 1);
		$question_data = $my_questions[$question_index];

		// echo("num_questions: " . $num_questions);
		// echo("question_index: " . $question_index);
		// echo("question_data: " . $question_Data);

		$question_id = $question_data[0];
		$question_text = $question_data[1];

		echo("Hint: apple is a pretty good choice for all the questions<br />");
		echo("Question: " . htmlentities($question_text) . "<br />\n");
		echo("<input name='questions' type='hidden' value='" . $question_id . "' /><br />\n");
		echo("Answer: <input name='answer_" . $question_id . "' /><br />\n");
		echo("<input type='submit' value='Log In' />");
	}

	function check_answer($my_questions, $question_id, $answer_text)
	{
		$my_question_array = array();
		$ret_val = FALSE;

		foreach ($my_questions as $question_array) {
			if($question_id == $question_array[0]) {
				$my_question_array = $question_array;
				break;
			}
		}
		
		//	Should check to be sure we got a good array from the foreach...
		if($answer_text == $my_question_array[2]) {
			$ret_val = TRUE;
		}

		return($ret_val);
	}
?>
<html>
    <head>
        <title>Complicated Authentication Example - Login Page</title>
    </head>
    <body>
		<form method="POST" action="login.php">
<?php
	if(isset($_POST["questions"])) {
		//	Test for correct answer to second-stage question
		$question_id = $_POST["questions"];
		$question_answer = $_POST["answer_" . $question_id];
		$correct_answer = check_answer($second_stage_questions, $question_id, $question_answer);
		if($correct_answer) {
			//	TOFIX - set up session correctly
			$_SESSION["user_data"] = 1;
			echo("<p>Congratulations you're logged in</p>");
			echo("<p>Go to the <a href='index.php'>main page</a> to do stuff");
		} else {
			echo("<p>Sorry that was the wrong answer.</p>\n");
			render_login_stuff();
		}
?>
			
<?php
	} else if(isset($_POST["username"])) {
		//	Test for correct answer to first-stage (uname/password) question
		//	and render second-stage question if correct

		if($_POST["username"] == "testuser" && $_POST["password"] == "password") {
			//	Got the username and password right. Randomly pick one of three second-stage questions
			render_second_stage($second_stage_questions);
		}
?>

<?php
	} else {
		//	Render first-stage question (uname/password)
		render_login_stuff();
	}
?>
		</form>
    </body>
</html>
<?php
	ob_flush();
?>
