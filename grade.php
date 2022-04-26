<?php session_start(); 

if(!ISSET($_SESSION['user'])){
	header('Location: ./');
}

include 'funcs.php';

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./style.css">
	<script type="text/javascript" src="./script.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Test Take</title>
</head>
<body>
    <div class="header">
        <ul>
        	<li><a href="./">Home</a></li>
          	<li><a href="./take.php">Take Test</a></li>
          	<li><a href="./owner.php">Your Tests</a></li>
            <li><a href="./logout.php">Logout</a></li>
		</ul>
	</div>
	<div class="main">
    	<h1>Your grade on test <?php echo $_POST['testid'];?></h1>
    	<?php

    	gradeTest($_POST, $_SESSION["user"]);

    	?>
	</div>
</body>

</html>