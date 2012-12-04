<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}

	function printHistory($history){
		echo '<tr>';
		echo '<td>';
		echo '<form action="update-edu.php" method="post">';
		echo '<table align="center">';
		echo '<tr><td>Name of institution</td><td><input '.(isset($history['new'])?'':'readonly').' type="text" name="name" value="'.htmlspecialchars($history['Name_of_School']).'"/></td></tr>';
		echo '<tr><td>Year of graduation</td><td><input '.(isset($history['new'])?'':'readonly').' type="number" name="year" value="'.htmlspecialchars($history['Year_of_Grad']).'"/></td></tr>';
		echo '<tr><td>Degree</td><td><input type="text" name="degree" value="'.htmlspecialchars($history['Degree']).'"/></td></tr>';
		echo '<tr><td>Major</td><td><input type="text" name="major" value="'.htmlspecialchars($history['Major']).'"/></td></tr>';
		echo '<tr><td>GPA</td><td><input type="text" name="gpa" value="'.htmlspecialchars($history['GPA']).'"/></td></tr>';
		echo '<tr><td><input type="submit" name="submit" value="'.(isset($history['new'])?'Add':'Update').'"/></td><td><input type="'.(isset($history['new'])?'reset':'submit').'" name="submit" value="'.(isset($history['new'])?'Clear':'Remove').'"/></td></tr>';
		echo '</table>';
		echo '</form>';
		echo '</td>';
		echo '</tr>';
	}
	echo '<h1>Education History</h1>';
	$hist = $con->prepare("SELECT * FROM EducationHistory WHERE Username=:u");
	$hist->bindParam(':u',$_SESSION['user']);
	$hist->execute();
	$count = 0;
	echo '<table border="1" align="center">';
	while($entry=$hist->fetch()){
		printHistory($entry);
		$count = $count + 1;
	}
	if($count < 3){
		printHistory(
			array(
				'Name_of_School'=>'',
				'Year_of_Grad'=>'',
				'Degree'=>'',
				'Major'=>'',
				'GPA'=>'',
				'new'=>True
			)
		);
	}
	echo '</table>';
	require 'foot.php'; 
?>
