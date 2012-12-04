<?php
	require 'head.php'; 
?>

<h2>Welcome!</h2>
<?php
	if(isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";
?>
<form action="login.php" method="post">
<input type="submit" name="submit" value="Log In!"/>
<input type="submit" name="submit" value="Register!"/>
</form>



<?php
	require 'foot.php'; 
?>
