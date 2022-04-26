<?php
session_start();
include 'funcs.php';

if(ISSET($_SESSION['user'])){
    header('Location: ./');
}

if(ISSET($_POST['username'])){
    if(validUser($_POST['username'], $_POST['password'])){
        $_SESSION['user'] = $_POST['username'];
        header('Location: ./');
    } else {
        $_SESSION['error'] = "Wrong username or password";
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
            <li><a href="./register.php">Register</a></li>
        </ul>
    </div>
    <div class="main">
        <form action="./login.php" method="POST">
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
                echo "<div style='color:red;' >Wrong username or password</div>";
                unset($_SESSION['error']);
            }
        ?>
    </div>
</body>

</html>