<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./style.css">
	<title>Test Take</title>
</head>
<body>
    <div class="header">
        <ul>
        	<?php
        		if(ISSET($_SESSION['user'])){
           			echo '<li><a href="./add.php">Add Test</a></li>';
            		echo '<li><a href="./take.php">Take Test</a></li>';
            		echo '<li><a href="./owner.php">Your Tests</a></li>';
            		echo '<li><a href="./logout.php">Logout</a></li>';
            	} else {
            		echo '<li><a href="./login.php">Login</a></li>';
            		echo '<li><a href="./register.php">Register</a></li>';
        		}
            ?>
		</ul>
	</div>
	<div class="main">
    	<h1>Welcome to Ryan Stack's project 2</h1>
    	<p>Project is titled Test Take</p>
	</div>
</body>

</html>