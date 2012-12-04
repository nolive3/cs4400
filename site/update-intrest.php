<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
	echo '<meta http-equiv="REFRESH" content="0;url=research-intrest.php"/>';
	switch($_POST['submit']){
		case 'Add':
			$remove=$con->prepare("INSERT INTO FacultyResearchIntrest VALUE (:u, :i)");
			$remove->bindParam(':u', $_SESSION['user']);
			$remove->bindParam(':i', $_POST['intrest']);
			$remove->execute();
			$remove->closeCursor();
			
			break;
		case 'Delete':
			$remove=$con->prepare("DELETE FROM FacultyResearchIntrest WHERE Username=:u AND Intrest=:i");
			$remove->bindParam(':u', $_SESSION['user']);
			$remove->bindParam(':i', $_POST['intrest']);
			$remove->execute();
			$remove->closeCursor();
			break;
		default:
			die('nothing selected');
	}

	require 'foot.php'; 
?>
