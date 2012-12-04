<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
?>
<h1>Student Report</h1>
<?php
	function printvals($name, $title, $grade){
		echo '<tr><td>';
		echo htmlspecialchars($name);
		echo '</td><td>';
		echo htmlspecialchars($title);
		echo '</td><td>';
		echo htmlspecialchars($grade);
		echo '</td></tr>';
	}
	$report = $con->prepare("SELECT RegUser.Name AS Name, Title, AVG(Grade) AS Grade FROM Registration JOIN Section JOIN RegUser ON Section.Username=RegUser.Username AND Registration.CRN=Section.CRN WHERE Grade_mode='Letter' GROUP BY Name");
	$report->bindColumn('Name', $name);
	$report->bindColumn('Title', $title);
	$report->bindColumn('Grade', $grade);
	if(!$report->execute()){
		print_r($report->errorInfo());
		die('failure');
	}
	echo '<table border="1" align="center">';
	echo '<tr><td>Instructor</td><td>Course Title</td><td>Average Grade</td></tr>';
	while($report->fetch()){
		printvals($name,$title,$grade);
	}
	$report->closeCursor();
	echo '</table>';
?>


<?php
	require 'foot.php'; 
?>
