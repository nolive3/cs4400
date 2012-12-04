<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}elseif($_SESSION['type']!='F'){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";
		die('user not faculty, redirecting');	
	}

	function printRow($row, $ind, $extra){
		echo '<tr><td>'.
			htmlspecialchars($row['Name']).'</td><td>'.
			htmlspecialchars($row['Grade']).'</td><td>'.
			'<form action="update-tutors.php" method="post"><input type="hidden" name="username" value="'.htmlspecialchars($row['Username']).'"/><input type="submit" name="submit" value="'.
			((in_array($row['Username'], $extra))?'Fire':'Hire').'"></form></td></tr>';
	}
	echo '<h1>Register for Spring 2013</h1>';
	echo '<table align="center" border="1">';
	echo '<tr><th>Name</th><th>Grade</th></tr>';
	$my_tutors = $con->prepare("SELECT DISTINCT TP.Username FROM TutorPosition AS TP JOIN Section AS S ON TP.Title=S.Title WHERE S.Username=:u");
	$my_tutors->bindParam(':u', $_SESSION['user']);
	if(!$my_tutors->execute()){
		print_r($my_tutors->errorInfo());
		die('failure');
	}
	$my_tutors = $my_tutors->fetchAll();
	$students = $con->prepare("SELECT RU.Name, St.Username, MAX(St.Grade) AS Grade FROM TutorApplication AS TA JOIN RegUser AS RU JOIN Registration AS St JOIN Section AS Se ON St.Username=RU.Username AND TA.Title=Se.Title AND TA.Username=St.Username WHERE Se.Username=:u GROUP BY St.Username");
	$students->bindParam(':u', $_SESSION['user']);
	if(!$students->execute()){
		print_r($students->errorInfo());
		die('failure2');
	}
	$students=$students->fetchAll();
	array_walk($students, 'printRow', array_column($my_tutors, 'Username'));
	echo '</table>';

	require 'foot.php'; 
?>
