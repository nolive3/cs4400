<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
	$tutor = $con->prepare("SELECT Title FROM TutorPosition WHERE Username=:u");
	$tutor->bindParam(':u',$_SESSION['user']);
	if(!$tutor->execute()){
		print_r($tutor->errorInfo());
		die('fail');
	}
	echo '<form action="add-log.php" method="post"><table align="center"> <tr> <td> Tutor Name: </td> <td>'.
		htmlspecialchars($_SESSION['name']).
		'</td></tr><tr><td>Course:</td><td><select required name="title"><option></option>';
		while($row = $tutor->fetch()){
			echo '<option>'.htmlspecialchars($row['Title']).'</option>';
		}
		echo '</select></td></tr><tr><td>Student ID:</td><td><input type="number" name="sid"/></td></tr><tr><td><input type="submit" name="submit" value="Add"/></td><td><input type="reset" value="clear"/></table></form>';

	require 'foot.php'; 
?>
