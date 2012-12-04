<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
?>
<h1>Admin Report</h1>
<?php
	function printvals($val, $ind){
		echo '<tr><td>';
		echo $ind;
		echo '</td><td>';
		echo htmlspecialchars($val);
		echo '</td></tr>';
	}
	$report = $con->prepare("SELECT SA.Title1 AS name, AVG(Grade) AS grade FROM Registration AS R JOIN (Section AS S JOIN SameAs AS SA ON S.Title=SA.Title2) ON R.CRN=S.CRN WHERE Grade_mode='Letter' GROUP BY SA.Title1");
	$report->bindColumn('name', $name);
	$report->bindColumn('grade', $grade);
	if(!$report->execute()){
		print_r($report->errorInfo());
		die('failure');
	}
	$report2 = $con->prepare("SELECT Title2 FROM SameAs WHERE Title1=:t ORDER BY Title2 ASC");
	$report2->bindParam(':t', $name);
	$report2->bindColumn('Title2', $title);
	$tmp = array();
	while($report->fetch()){
		if(!$report2->execute()){
			print_r($report->errorInfo());
			die('failure2');
		}
		if($report2->fetch()){
			$t=htmlspecialchars($title);
		}
		while($report2->fetch()){
			$t=$t.'<br/>'.htmlspecialchars($title);
		}
		$tmp[$t] = $grade;
		$report2->closeCursor();
	}
	$report->closeCursor();
	echo '<table border="1" align="center">';
	echo '<tr><td>Course Title</td><td>Average Grade</td></tr>';
	array_walk($tmp, 'printvals');
	echo '</table>';
?>


<?php
	require 'foot.php'; 
?>
