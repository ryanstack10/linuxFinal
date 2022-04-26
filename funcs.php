<?php 

class User {
	public $username;
	public $password;

	function __construct($u, $p, $t){
		$this->username = $u;
		$this->password = $p;
		$this->tests = $t;
	}
}

class Test {
	public $average;
	public $users;
	public $id;

	function __construct($scores, $u, $i){
		$sum = array_sum($scores);
		$this->average = $sum / sizeof($scores);
		$this->users = $u;
		$this->id = $i;
	}
}

function getUsers(){
	$files = scandir('./users/');
	$users = [];

	foreach ($files as $file) {
		if($file != '.' && $file != '..'){
			$openFile = fopen('./users/' . $file, "r");
			$userName = rtrim(fgets($openFile), "\n");
			$currentUser = new User($userName, fgets($openFile), getTestsForUser($userName));
			array_push($users, $currentUser);
			fclose($openFile);
		}
	}

	return $users;
}

function getTestsForUser($user) {
	$files = scandir('./tests/');
	$tests = [];
	foreach($files as $file){
		if($file != '.' && $file != '..' && preg_match("/\d+/", $file)){
		$test = json_decode(rtrim(fgets(fopen('./tests/' . $file, "r")), "\n"), true);
		if($test["owner"] == $user){
			array_push($tests, $file);
		}
	}
}

	return $tests;
}

function validUser($username, $password){
	$users = getUsers();

	foreach ($users as $user) {
		if($user->username == $username){
			return $user->password == hash('sha256', $password);
		}
	}

	return false;
}

function addUser($username, $password){
	$users = getUsers();

	foreach ($users as $user) {
		if($user->username == $username){
			return false;
		}
	}

	$file = fopen('./users/' . $username, "w+");
	fwrite($file, $username . "\n" . hash('sha256', $password));
	fclose($file);

	return true;
}

function addTest($test){
	$files = scandir('./tests/');
	file_put_contents('./tests/' . (sizeof($files) - 2),json_encode($test));
	return sizeof($files) - 2;
}

function displayTest($testNum){
	$test = json_decode(rtrim(fgets(fopen('./tests/' . $testNum, "r")), "\n"));

	$questionNum = 0;
	$title = $test->title;
	echo "<h1>{$title}</h1>";
	foreach ($test as $key => $value) {
		if(preg_match("/^q\d+$/i", $key)){
			$questionNum++;
			echo "<label>{$questionNum}.) {$value}</label><br><br>"; 
		}elseif(preg_match("/^q\d+a\d+i$/i", $key)){
			echo "<input id='{$key}' type='radio' name=q{$questionNum}r value='{$key}'><label for='{$key}'>{$value}</label><br>";
		}
	}

}

function gradeTest($answers, $user){
	$test = json_decode(rtrim(fgets(fopen('./tests/' . $answers["testid"], "r")), "\n"), true);
	$correct = 0;
	$incorrect = 0;
	foreach ($answers as $key => $value) {
		if(strlen($key) == 3){
			if($test[$key] == $value){
				$correct++;
			} else {
				$incorrect++;
			}
			
		}
	}

	$totalNum = ($correct + $incorrect);
	$score = ($correct * 100 / $totalNum);

	echo "<div>You have gotten {$correct} out of " . $totalNum . "</div>";
	echo "<div>For a grade of  " . $score . "%</div>";

	saveScore($score, $user, $answers["testid"]);
}

function saveScore($score, $user, $test){
	$files = scandir('./tests/');
	file_put_contents('./tests/' . $test . '.scores', $score . ' ' . $user . "\n", FILE_APPEND);
}

function getScore($test){
	$file=fopen('./tests/' . $test . '.scores', 'r');
	$scores = [];
	$users = [];

	while(! feof($file)) {
  		$line = explode(" ", fgets($file));
  		if(sizeof($line) == 2){
  		array_push($scores, intval($line[0]));
  		array_push($users, trim($line[1]));
  	}
  	}
  	return new Test($scores, array_unique($users), $test);
}

function getScores($tests){
	$returnObj = [];
	foreach($tests as $test){
		array_push($returnObj, getScore($test));
	}

	return $returnObj;
}

function getScoresForUser($username){
	$users = getUsers();

	foreach ($users as $user) {
		if($user->username == $username){
			return getScores($user->tests);
		}
	}

	return false;
}

function getTestNameFromId($id){
	return json_decode(rtrim(fgets(fopen('./tests/' . $id, "r")), "\n"), true)["title"];
}

function displayOwnerTest($username){
	$tests = getScoresForUser($username);

	foreach($tests as $test){
		$testName = getTestNameFromId($test->id);
		echo "<tr>";
		echo "<td>{$testName}</td>";
		echo "<td>{$test->average}</td>";
		echo "<td><button onclick='window.location=`./testers.php?id={$test->id}`'>Tested users</button></td>";
		echo "</tr>";
	}
}

function displayUsers($id){
	$users = getScore($id)->users;

	foreach($users as $user){
		echo "<tr><td>{$user}</td></tr>";
	}
}

?>