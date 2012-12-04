<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}else if($_SESSION['type'] != 'F'){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";
		die('not a faculty, redirecting');
	}
	switch($_POST['submit']){
		case 'Hire':
			$add=$con->prepare("INSERT INTO Tutor VALUE (:user)");
			$add->bindParam(':user', $_POST['username']);
			if(!$add->execute()){
				#user is already a tutor for something
			}
			$add=$con->prepare("INSERT INTO TutorPosition(Username, Title) VALUE (:user,(SELECT MAX(Title) From Section WHERE Username=:prof))");
			$add->bindParam(':prof', $_SESSION['user']);
			$add->bindParam(':user', $_POST['username']);
			if(!$add->execute()){
				print_r($add->errorInfo());
				die('failed to more hire');
			}
			break;
		case 'Fire':
			$add=$con->prepare("DELETE FROM TutorPosition WHERE Username=:user AND Title IN (SELECT Title From Section WHERE Username=:prof)");
			$add->bindParam(':prof', $_SESSION['user']);
			$add->bindParam(':user', $_POST['username']);
			if(!$add->execute()){
				print_r($add->errorInfo());
				die('failed to fire');
			}
			$add=$con->prepare("SELECT * FROM TutorPosition WHERE Username=:user");
			$add->bindParam(':user', $_POST['username']);
			if(!$add->execute()){
				print_r($add->errorInfo());
				die('failed to more fire');
			}
			if(!$add->fetch()){
				$add=$con->prepare("DELETE FROM Tutor WHERE Username=:user");
				$add->bindParam(':user', $_POST['username']);
				if(!$add->execute()){
					print_r($add->errorInfo());
					die('failed to more more fire');
				}
			}
			$add->closeCursor();
			break;
		default:
			die('nothing selected');
	}

	echo '<meta http-equiv="REFRESH" content="0;url=assign-tutors.php"/>';
	require 'foot.php'; 
?>
