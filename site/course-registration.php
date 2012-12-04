<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}else if($_SESSION['type'] != 'S'){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";
		die('not a student, redirecting');
	}

	

	function printRow($row, $ind, $extra){
		$crns = $extra['crn'];
		$modes = $extra['mode'];
		echo '<tr><form action="update-registration.php" method="post"><td>'.htmlspecialchars($row['title']).'</td><td>'.htmlspecialchars($row['section']).'</td><td>'.
		'<select name="mode" required>
		<option'.(!isset($modes[$row['CRN']])?' selected':'').'></option>
		<option'.((isset($modes[$row['CRN']]) and $modes[$row['CRN']]=='Letter')?' selected':'').'>Letter</option>
		<option'.((isset($modes[$row['CRN']]) and $modes[$row['CRN']]=='Pass-Fail')?' selected':'').'>Pass-Fail</option>
		<option'.((isset($modes[$row['CRN']]) and $modes[$row['CRN']]=='Audit')?' selected':'').'>Audit</option>
		</select>'.
		'</td><td>'.htmlspecialchars($row['time']).'</td><td>'.htmlspecialchars($row['day']).'</td><td>'.htmlspecialchars($row['location']).'</td><td>'.htmlspecialchars($row['instructor']).'</td><td><input readonly name="CRN" value="'.htmlspecialchars($row['CRN']).'"></td><td><input type="submit" name="submit" value="'.(in_array($row['CRN'],$crns)?'Drop':'Add').'"></td></form></tr>';
	}
	echo '<h1>Register for Spring 2013</h1>';
	echo '<h2>'.$_SESSION['major'].'</h2>';
	echo '<table align="center" border="1">';
	echo '<tr><th>Course</th><th>Section</th><th>Grading Mode</th><th>Time</th><th>Day</th><th>Location</th><th>Instructor</th><th>CRN</th></tr>';
	$registered_for = GetRegisteredCourses($con, $_SESSION['user'], 'Spring 2013');
	#print_r($registered_for);
	$tm=GetRegisteredCourses($con, null, 'Spring 2013');
	#print_r($tm);
	array_walk($tm, 'printRow', array( 'crn'=>array_column($registered_for, 'CRN'), 'mode'=>array_keyval($registered_for, 'CRN','mode')));
	echo '</table>';
	echo '<form action="view-courses.php"><input type="submit" value="Done"/></form>';
	require 'foot.php'; 
?>
