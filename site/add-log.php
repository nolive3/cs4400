<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}

	$new = $con->prepare("INSERT INTO TutorLog (TutorUsername, StudentUsername, SectionCRN, DateTime) VALUE (:u, (SELECT Username FROM Student WHERE Student_Id=:id), (SELECT MIN(Registration.CRN) FROM Registration JOIN Student JOIN Section ON Student.Username=Registration.Username AND Registration.CRN=Section.CRN WHERE Student.Student_Id=:id AND Section.Title=:title), :date)");
	$new->bindParam(':date', $now);
	$new->bindParam(':id', $_POST['sid']);
	$new->bindParam(':title', $_POST['title']);
	$new->bindParam(':u', $_SESSION['user']);
	$now = date('Y-m-d H:i:s');
	if($new->execute()){
		echo '<h1>Success</h1><meta http-equiv="REFRESH" content="5;url=tutor-logbook.php"/>';
	}else{
		print_r($new->errorInfo());
		echo 'Failure';
	}
	
?>



<?php
	require 'foot.php'; 
?>
