<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}else if($_SESSION['type'] != 'S'){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";
		die('not a student, redirecting');
	}
	echo '<meta http-equiv="REFRESH" content="0;url=course-registration.php"/>';
	switch($_POST['submit']){
		case 'Add':
			$add=$con->prepare("INSERT INTO Registration(Username, CRN, Grade_mode) VALUE (:user,:crn,:mode)");
			$add->bindParam(':user', $_SESSION['user']);
			$add->bindParam(':crn', $_POST['CRN']);
			$add->bindParam(':mode', $_POST['mode']);
			if(!$add->execute()){
				print_r($add->errorInfo());
				die('failed to register');
			}
			break;
		case 'Drop':
			$add=$con->prepare("DELETE FROM Registration WHERE Username=:user AND CRN=:crn");
			$add->bindParam(':user', $_SESSION['user']);
			$add->bindParam(':crn', $_POST['CRN']);
			if(!$add->execute()){
				print_r($add->errorInfo());
				die('failed to register');
			}
			break;
		default:
			die('nothing selected');
	}

	require 'foot.php'; 
?>
