<?php
	require 'head.php'; 
?>

<?php
	if(!isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
	else{
		echo "<h1> WELCOME ".htmlspecialchars(isset($_SESSION['name'])?$_SESSION['name']:$_SESSION['user'])."!</h1>";
		switch($_SESSION['type']){
			case 'A':
				{
					echo '<table align="center"><tr><td><a href="admin-report.php">View Administrative Report</a></td></tr>';
					
				}
				break;
			case 'R':
				GetUserData($con);
				echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";	
				break;
			
			case 'D':
				echo "DBA view!<br/>";
				break;
			case 'S':
				if(RegUserInfoComplete($con)){
					echo '<table align="center"><tr><td><a href="personal-info.php">Personal Information</a></td></tr>';
					echo '<tr><td><a href="student-info.php">Student Information</a></td></tr>';
					echo '<tr><td><a href="edu-history.php">Education History</a></td></tr>';
					echo '<tr><td><a href="StudentServices.php">Student Services</a></td></tr></table>';
				}else{
					echo "Student View! Please ";
					echo '<a href="personal-info.php">Complete Registration</a>';
				}
				break;
			case 'F':
				if(RegUserInfoComplete($con)){
					echo '<table align="center"><tr><td><a href="personal-info.php">Personal Information</a></td></tr>';
					echo '<tr><td><a href="faculty-info.php">Faculty Information</a></td></tr>';
					echo '<tr><td><a href="research-intrest.php">Research Intrests</a></td></tr>';
					echo '<tr><td><a href="FacultyServices.php">Faculty Services</a></td></tr></table>';
			
				}else{
					echo "Faculty View! Please ";
					echo '<a href="personal-info.php">Complete Registration</a>';
				}
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