<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
?>
<h1>Faculty Report</h1>
<?php
	function printvals($val, $ind){
		echo '<tr><td rowspan="3">';
		echo $ind;
		echo '</td><td>';
		echo '&gt3';
		echo '</td><td>';
		echo htmlspecialchars($val[2]);
		echo '</td></tr>';
		echo '<tr></td><td>';
		echo '1-3';
		echo '</td><td>';
		echo htmlspecialchars($val[1]);
		echo '</td></tr>';
		echo '<tr></td><td>';
		echo 'None';
		echo '</td><td>';
		echo htmlspecialchars($val[0]);
		echo '</td></tr>';
	}
	$report2 = $con->prepare("SELECT AVG(Grade) AS grade, GROUP_CONCAT(DISTINCT Title2 ORDER BY Title2) AS name 
		FROM Registration JOIN SameAs JOIN Section
		ON SameAs.Title2=Section.Title AND 
		Registration.CRN=Section.CRN 
		WHERE Grade_mode='Letter' AND
		NOT EXISTS (SELECT TL.StudentUsername FROM TutorLog AS TL
		WHERE TL.SectionCRN=Section.CRN
		AND TL.StudentUsername=Registration.Username
		GROUP BY Registration.Username)
		GROUP BY Title1;");
	$report2->bindColumn('name', $title);
	$report2->bindColumn('grade', $grade);
	$tmp = array();
	if(!$report2->execute()){
		print_r($report2->errorInfo());
		die('failure2');
	}
	while($report2->fetch()){
		$tmp[$title][0]=$grade;
	}
	$report2->closeCursor();
	$report2 = $con->prepare("SELECT AVG(Grade) AS grade, GROUP_CONCAT(DISTINCT Title2 ORDER BY Title2) AS name 
		FROM Registration JOIN SameAs JOIN Section
		ON SameAs.Title2=Section.Title AND 
		Registration.CRN=Section.CRN 
		WHERE Grade_mode='Letter' AND
		EXISTS (SELECT TL.StudentUsername FROM TutorLog AS TL
		WHERE TL.SectionCRN=Section.CRN
		AND TL.StudentUsername=Registration.Username
		GROUP BY Registration.Username
		HAVING COUNT(*)<3)
		GROUP BY Title1");
	$report2->bindColumn('name', $title);
	$report2->bindColumn('grade', $grade);
	if(!$report2->execute()){
		print_r($report2->errorInfo());
		die('failure2');
	}
	while($report2->fetch()){
		$tmp[$title][1]=$grade;
	}
	$report2->closeCursor();
	$report2 = $con->prepare("SELECT AVG(Grade) AS grade, GROUP_CONCAT(DISTINCT Title2 ORDER BY Title2) AS name 
		FROM Registration JOIN SameAs JOIN Section
		ON SameAs.Title2=Section.Title AND 
		Registration.CRN=Section.CRN 
		WHERE Grade_mode='Letter' AND
		EXISTS (SELECT TL.StudentUsername FROM TutorLog AS TL
		WHERE TL.SectionCRN=Section.CRN
		AND TL.StudentUsername=Registration.Username
		GROUP BY Registration.Username
		HAVING COUNT(*)>3)
		GROUP BY Title1");
	$report2->bindColumn('name', $title);
	$report2->bindColumn('grade', $grade);
	if(!$report2->execute()){
		print_r($report2->errorInfo());
		die('failure2');
	}
	while($report2->fetch()){
		$tmp[$title][2]=$grade;
	}
	$report2->closeCursor();
	echo '<table border="1" align="center">';
	echo '<tr><th>Course Title</th><th>Tutor Meetings</th><th>Average Grade</th></tr>';
	array_walk($tmp, 'printvals');
	echo '</table>';
?>


<?php
	require 'foot.php'; 
?>
