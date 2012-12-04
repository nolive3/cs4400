<?php
	require 'head.php'; 
?>


<?php
	if(!isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
	else{
		$finalize = $con->prepare("UPDATE RegUser SET Address=:a, Name=:n, Email=:e, DateOfBirth=:d, PermanentAddress=:p, Gender=:g, ContactNumber=:c WHERE Username=:u");
		$finalize->bindParam(':u', $_SESSION['user']);
		$finalize->bindParam(':a', $_POST['address']);
		$finalize->bindParam(':n', $_POST['Name']);
		$finalize->bindParam(':e', $_POST['email']);
		$finalize->bindParam(':d', $_POST['DoB']);
		$finalize->bindParam(':p', $_POST['permaddress']);
		$finalize->bindParam(':g', $_POST['Gender']);
		$finalize->bindParam(':c', $_POST['contactnum']);
		if($finalize->execute()){
			$finalize->closeCursor();
			

			$_SESSION['type'] = 'R'; #force re fetch name
			GetUserData($con);
			if($_SESSION['type'] == 'S'){
				echo '<meta http-equiv="REFRESH" content="0;url=student-info.php"/>';
			}elseif($_SESSION['type'] == 'F'){
				echo '<meta http-equiv="REFRESH" content="0;url=faculty-info.php"/>';
			}
		}else{
			die();
		}
	}
?>

<?php
	require 'foot.php'; 
?>
