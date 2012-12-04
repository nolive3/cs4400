<?php session_start(); ?>
<html>
<body>


<div style="border-style:solid;">

<div style="background-color:gold; height:10%;">

<img src="Buzz-title.png" style="height:100%; float:left"/>
<h1 style="height:100%; display:inline;">Team19Port</h1>
<br/>
<?php
if(isset($_SESSION['user'])){
	echo " <a href=\"welcome.php\">Home</a> ";
if($_SESSION['type']=='D')
	echo " <a href=\"tables.php\">Table Overview</a> ";
	echo " <a href=\"logout.php\">Log out!</a> ";
}
?>
</div>

<div style="float:center; width:100%; text-align:center;">

<?php
$con = new PDO("mysql:host=localhost;dbname=cs4400_Group19","group","hunter2");
if(!$con)
	die("Database error");

$grade_vals = array(
	'Pass-Fail'=>array('Fail','Pass'), 
	'Audit'=>array('Failed', 'Successful'), 
	'Letter'=>array('F','D','C','B','A')
);

function GetUserData($con){
	if($_SESSION['type'] == 'R'){
		$res = $con->prepare("SELECT Type, Name FROM RegUser WHERE Username=:user;");
		$res->bindParam(':user', $_SESSION['user']);
		$res->bindColumn('Type', $type);
		$res->bindColumn('Name', $_SESSION['name']);
		$res->execute();
		if($res->fetch()){
			$_SESSION['type']=$type;
			$res->closeCursor();
		}else{
			print_r($res->errorInfo());
			die("db error");
		}
	}
}

function GetRegisteredCourses($con, $user, $semester){
	if(!isset($semester)){
		$get = $con->prepare("SELECT S.Term AS term, R.CRN AS CRN, R.Grade_mode AS mode, R.Grade AS grade, S.Title AS title, S.Letter AS section, S.Time AS time, S.Day AS day, S.Location AS location, RU.Name AS instructor FROM Registration AS R JOIN Section AS S JOIN RegUser AS RU ON RU.Username=S.Username AND R.CRN=S.CRN WHERE R.Username=:u");
		$get->bindParam(':u', $user);
	}elseif(!isset($user)){
		$get = $con->prepare("SELECT S.CRN AS CRN, S.Title AS title, S.Letter AS section, S.Time AS time, S.Day AS day, S.Location AS location, RU.Name AS instructor FROM Section AS S JOIN RegUser AS RU JOIN Course AS C ON RU.Username=S.Username AND C.Title=S.Title WHERE Term=:t AND C.Dept_Id=:dept");
		$get->bindParam(':dept', $_SESSION['major']);
		$get->bindParam(':t', $semester);
	}else{
		$get = $con->prepare("SELECT R.CRN AS CRN, R.Grade_mode AS mode, S.Title AS title, S.Letter AS section, S.Time AS time, S.Day AS day, S.Location AS location, RU.Name AS instructor FROM Registration AS R JOIN Section AS S JOIN RegUser AS RU ON RU.Username=S.Username AND R.CRN=S.CRN WHERE Term=:t AND R.Username=:u");
		$get->bindParam(':u', $user);
		$get->bindParam(':t', $semester);
	}
	if(!$get->execute()){
		print_r($get->errorInfo());
		die('registration failure');
	}
	return $get->fetchAll();
}


function array_column($array, $column)
{
	$ret=array();
	foreach ($array as $row) $ret[] = $row[$column];
	return $ret;
}
function array_keyval($array, $key, $val)
{
	$ret = array();
	foreach ($array as $row) $ret[$row[$key]] = $row[$val];
	return $ret;
}

function RegUserInfoComplete($con){
	GetUserData($con);
	if($_SESSION['type'] == 'S'){
		$finalize = $con->prepare("SELECT Student_Id AS ID, Major FROM Student WHERE Username=:u");
		$finalize->bindColumn('Major', $_SESSION['major']);
	}elseif($_SESSION['type'] == 'F'){
		$finalize = $con->prepare("SELECT Instructor_Id AS ID FROM Faculty WHERE Username=:u");
	}else{
		die('RegUserInfoComplete called on something which is not a faculty or student');
	}
	$finalize->bindParam(':u', $_SESSION['user']);
	$finalize->bindColumn('ID', $_SESSION['ID']);
	$finalize->execute();
	if($res=$finalize->fetch()){
		$finalize->closeCursor();
		return True; 
	}else{
		$finalize->closeCursor();
		return False;
	}
}
?>

