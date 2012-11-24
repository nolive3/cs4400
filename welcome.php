<?php
	require 'head.php'; 
?>

<?php
	if(!isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
	else{
		echo "<h1> WELCOME ".htmlspecialchars($_SESSION['user'])."!</h1>";
		switch($_SESSION['type']){
			case 'A':
				echo "Admin View!<br/>";
				break;
			case 'R':
				$res = $con->prepare("SELECT Type FROM RegUser WHERE Username=:user;");
				$res->bindParam(':user', $_SESSION['user']);
				$res->bindColumn('Type', $type);
				$res->execute();
				if($res->fetch()){
					$_SESSION['type']=$type;
					$res->closeCursor();
				}
				echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";	
				break;
			
			case 'D':
				echo "DBA view!<br/>";
				break;
			case 'S':
				echo "Student View!<br/>";
				break;
			case 'F':
				echo "Faculty View!<br/>";
				break;
			default:
				echo "fail!<br/>";
				break;
		}
	}
?>

<?php
	require 'foot.php'; 
?>
