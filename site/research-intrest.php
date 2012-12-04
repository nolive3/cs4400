<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}

	function printIntrest($intrest){
		echo '<form action="update-intrest.php" method="post">';
		echo '<tr><td><input '.(isset($intrest['new'])?'':'readonly').' type="text" name="intrest" value="'.htmlspecialchars($intrest['Intrest']).'"/></td><td><input type="submit" name="submit" value="'.(isset($intrest['new'])?'Add':'Delete').'"/></td></tr>';
		echo '</form>';
	}
	echo '<h1>Research Intrests</h1>';
	$hist = $con->prepare("SELECT * FROM FacultyResearchIntrest WHERE Username=:u");
	$hist->bindParam(':u',$_SESSION['user']);
	$hist->execute();
	echo '<table border="1" align="center">';
	while($entry=$hist->fetch()){
		printIntrest($entry);
	}
	printIntrest(
		array(
			'Intrest'=>'',
			'new'=>True
		)
	);
	echo '</table>';
	echo '<form><input type="submit" formaction="welcome.php" value="Cancel"/></form>';
	require 'foot.php'; 
?>
