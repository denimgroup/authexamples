<?php
	session_start();
?>
<html>
	<head>
		<title>Complicated Authentication Example - Index Page</title>
	</head>
	<body>
<?php
	if(isset($_SESSION["user_data"])) {
		$has_session = 1;
	}
?>
		<p>Welcome to a complicated authentication example.<p>
<?php
	if(isset($has_session)) {
?>
		<p>You're logged in</p>
		<p>Click <a href="authenticated.php">here</a> to view a totally awesome authenticated page.</p>
		<p>Click <a href="logout.php">here</a> to log out.</p>
<?php
	} else {
?>
		<p>You're NOT logged in</p>
		<p>Click <a href="login.php">here</a> to log in.</p>
<?php
	}
?>
	</body>
</html>
