<?php
    session_start();
    if(!isset($_SESSION["user_data"])) {
		header("Location: index.php");
		exit;
	}
?>
<html>
    <head>
        <title>Complicated Authentication Example - Authenticated Page</title>
    </head>
    <body>
        <p>Welcome to the authenticated page.<p>
		<p>Click <a href="index.php">here</a> to go home.</p>
		<p>Click <a href="logout.php">here</a> to log out.</p>
    </body>
</html>
