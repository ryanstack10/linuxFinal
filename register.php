<?php

session_start();
include 'funcs.php';

if(ISSET($_SESSION['user'])){
	header('Location: ./');
}

if(ISSET($_POST['username'])){
    if(addUser($_POST['username'], $_POST['password'])){
        $_SESSION['user'] = $_POST['username'];
        header('Location: ./');
    } else {
        $_SESSION['error'] = "Username already exists";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./style.css">
	<title>Test Take</title>
</head>
<body>
    <div class="header">
        <ul>
            <li><a href="./">Home</a></li>
            <li><a href="./login.php">Login</a></li>
        </ul>
    </div>
    <div class="main">
        <form action="./register.php" method="POST">
            <div>Username:</div>
            <input type="text" name="username" placeholder="username" required>
            <div>Password:</div>
            <input type="password" name="password" placeholder="password" required>
            <br>
            <br>
            <input type="submit" value="Submit">
        </form>
        <?php 
            if(ISSET($_SESSION['error'])){
                echo "<div style='color:red;'>Username already exists</div>";
                unset($_SESSION['error']);
            }
        ?>
    </div>
</body>

</html>