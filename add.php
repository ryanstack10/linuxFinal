<?php session_start(); 

if(!ISSET($_SESSION['user'])){
	header('Location: ./');
}

include 'funcs.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$testName = addTest($_POST);
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./style.css">
	<script type="text/javascript" src="./script.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Test Take</title>
	<?php
		if(ISSET($testName)){
			echo "<script>alert('Your test has the id of {$testName}');</script>";
		}
	?>
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
    	<h1>Add a test</h1>
    	<form action='./add.php' method='POST'>
    		<input name="owner" type="hidden" value="<?php echo $_SESSION['user'];?>">
    		<label for="title">Title: </label><input id="title" type="text" name="title">
    		<br><br>
    		<div id="questions">
    			<div id='d1'>
    				1.) <input id='q1' name='q1'><button type="button" onclick="removeQuestion(1);">X</button>
    				<div id="q1a">
    					<input type="radio" id="q1a1r" name="q1r" value="q1a1i"><label for="q1a1r"><input type='text' id='q1a1i' name='q1a1i'></label><br>
					</div>
					<button type="button" onclick="addAnswer(1);">Add Answer</button>
    			</div>
    			<br id='br1'>
    		</div>
    		<input type='submit' value='Submit'>
    		<button type="button" onclick="addQuestion();">Add Question</button>
    	</form>
	</div>
</body>

</html>