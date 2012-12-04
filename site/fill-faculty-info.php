<?php
	require 'head.php'; 
?>


<?php
	if(!isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
	else{
		$finalize = $con->prepare("UPDATE Faculty SET Position=:p, Dept_Id=:d WHERE Username=:u");
		$finalize->bindParam(':u', $_SESSION['user']);
		$finalize->bindParam(':p', $_POST['Position']);
		$finalize->bindParam(':d', $_POST['Department']);
		if($finalize->execute()){
			$finalize->closeCursor();
			

			$_SESSION['type'] = 'R'; #force re fetch name
			GetUserData($con);
			echo "<meta http-equiv=\"REFRESH\" content=\"0;url=research-intrest.php\"/>";
		}else{
			die('Execute problem');
		}
	}
?>

<?php
	require 'foot.php'; 
?>
