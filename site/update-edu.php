<?php
	require 'head.php'; 

	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
	echo '<meta http-equiv="REFRESH" content="0;url=welcome.php"/>';
	switch($_POST['submit']){
		case 'Add':
			$remove=$con->prepare("INSERT INTO EducationHistory VALUE (:u, :school, :year, :deg, :maj, :gpa)");
			$remove->bindParam(':u', $_SESSION['user']);
			$remove->bindParam(':school', $_POST['name']);
			$remove->bindParam(':year', $_POST['year']);
			$remove->bindParam(':deg', $_POST['degree']);
			$remove->bindParam(':maj', $_POST['major']);
			$remove->bindParam(':gpa', $_POST['gpa']);
			$remove->execute();
			$remove->closeCursor();
			break;
		case 'Update':
			$remove=$con->prepare("UPDATE EducationHistory SET Degree=:deg, Major=:maj, GPA=:gpa WHERE Username=:u AND Name_of_School=:school AND Year_of_Grad=:year");
			$remove->bindParam(':u', $_SESSION['user']);
			$remove->bindParam(':school', $_POST['name']);
			$remove->bindParam(':year', $_POST['year']);
			$remove->bindParam(':deg', $_POST['degree']);
			$remove->bindParam(':maj', $_POST['major']);
			$remove->bindParam(':gpa', $_POST['gpa']);
			echo print_r($_POST);
			$remove->execute();
			$remove->closeCursor();
			break;
		case 'Remove':
			$remove=$con->prepare("DELETE FROM EducationHistory WHERE Username=:u AND Name_of_School=:school AND Year_of_Grad=:year");
			$remove->bindParam(':u', $_SESSION['user']);
			$remove->bindParam(':school', $_POST['name']);
			$remove->bindParam(':year', $_POST['year']);
			$remove->execute();
			$remove->closeCursor();
			break;
		default:
		die('nothing selected');
	}

	require 'foot.php'; 
?>
