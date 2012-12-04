<?php
	require 'head.php'; 
?>


<?php
	if(!isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
	else{
		$finalize = $con->prepare("UPDATE Student SET Degree=:d, Major=:m WHERE Username=:u");
		$finalize->bindParam(':u', $_SESSION['user']);
		$finalize->bindParam(':d', $_POST['Degree']);
		$finalize->bindParam(':m', $_POST['Department']);
		if($finalize->execute()){
			$finalize->closeCursor();
			

			$_SESSION['type'] = 'R'; #force re fetch name
			GetUserData($con);
			echo "<meta http-equiv=\"REFRESH\" content=\"0;url=edu-history.php\"/>";
		}else{
			die();
		}
	}
?>

<?php
	require 'foot.php'; 
?>
