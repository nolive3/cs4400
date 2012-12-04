<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
?>

	<table align="center">
	<tr><form><td><input type="number" name="crn"/></td><td><input type="submit" name="submit" value="Search by CRN"/></td></form>
	<td>OR</td><form><td><input type="text" name="title"/></td><td><input type="submit" name="submit" value="Search by Title"/></td></form></tr>
	</table>
<?php

	if(isset($_GET['submit'])){
		switch($_GET['submit']){
			case 'Search by Title':
			$tutors = $con->prepare("SELECT Course.Title, GROUP_CONCAT(RegUser.Name, '<', RegUser.Email, '>' SEPARATOR ', ') AS res FROM Course JOIN RegUser JOIN TutorPosition ON RegUser.Username = TutorPosition.Username AND Course.Title = TutorPosition.Title WHERE Course.Title LIKE :t GROUP BY Course.Title;");
			$tutors->bindParam(':t', $_GET['title']);
			$_GET['title'] = '%'.$_GET['title'].'%';
			if(!$tutors->execute()){
				print_r($tutors->errorInfo());
				die('tutor failure');
			}
			echo '<table align="center" border="1"><tr><th>Course Name</th><th>Tutor</th></tr>';
			while($res = $tutors->fetch()){
				echo '<tr><td>'.htmlspecialchars($res['Title']).'</td><td>'.htmlspecialchars($res['res']).'</td></tr>';
			}
			echo '</table>';
			break;
			case 'Search by CRN':
			$tutors = $con->prepare("SELECT Section.Title, GROUP_CONCAT(RegUser.Name, '<', RegUser.Email, '>' SEPARATOR ', ') AS res FROM Section JOIN RegUser JOIN TutorPosition ON RegUser.Username = TutorPosition.Username AND Section.Title = TutorPosition.Title WHERE Section.CRN = :t GROUP BY Section.Title;");
			$tutors->bindParam(':t', $_GET['crn']);
			if(!$tutors->execute()){
				print_r($tutors->errorInfo());
				die('tutor failure');
			}
			echo '<table align="center" border="1"><tr><th>Course Name</th><th>Tutor</th></tr>';
			while($res = $tutors->fetch()){
				echo '<tr><td>'.htmlspecialchars($res['Title']).'</td><td>'.htmlspecialchars($res['res']).'</td></tr>';
			}
			echo '</table>';
			break;
			default:
			break;
		}
	}

	require 'foot.php'; 
?>
