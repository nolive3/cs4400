<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}else if($_SESSION['type'] != 'S'){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";
		die('not a student, redirecting');
	}

	function printRow($row, $ind, $grade_vals){
		echo '<tr><td>'.htmlspecialchars($row['title']).'</td><td>'.htmlspecialchars($row['section']).'</td><td>'.htmlspecialchars($row['mode']).'</td><td>'.
		$grade_vals[$row['mode']][$row['grade']].
		'</td><td>'.htmlspecialchars($row['time']).'</td><td>'.htmlspecialchars($row['day']).'</td><td>'.htmlspecialchars($row['location']).'</td><td>'.htmlspecialchars($row['instructor']).'</td><td>'.htmlspecialchars($row['term']).'</td><td>'.htmlspecialchars($row['CRN']).'</td></tr>';
	}
	echo '<h1>Registered Courses</h1>';
	echo '<table align="center" border="1">';
	echo '<tr><th>Course</th><th>Section</th><th>Grading Mode</th><th>Grade</th><th>Time</th><th>Day</th><th>Location</th><th>Instructor</th><th>Term</th><th>CRN</th></tr>';
	array_walk(GetRegisteredCourses($con, $_SESSION['user'], null), 'printRow', $grade_vals);
	echo '</table>';
	require 'foot.php'; 
?>
