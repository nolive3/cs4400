<?php
	require 'head.php'; 
?>

<?php
	if(isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";
?>

<?php
	$insrt=$con->prepare("INSERT INTO User (Username, Password, Type) VALUE (:user, :pass, 'R');");
	$insrt->bindParam(':user', $_POST['username']);
	$insrt->bindParam(':pass', $_POST['password']);
	if(!isset($_POST["submit"]) or $_POST["submit"]=="Cancel!"){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
	}elseif(!empty($_POST["username"])
	and !empty($_POST["password"])
	and !empty($_POST["confpassword"])
	and !empty($_POST["type"])
	and (!strcmp($_POST["type"], "Student") or !strcmp($_POST["type"], "Faculty"))
	and $_POST["password"] == $_POST["confpassword"]
	and $insrt->execute()) {
		$insrt->closeCursor();
		$type = chr(ord($_POST["type"]));
		$insrt=$con->prepare("INSERT INTO RegUser (Username, Type) VALUE (:user, :type);");
		$insrt->bindParam(':user', $_POST['username']);
		$insrt->bindParam(':type', $type);
		$_SESSION['user'] = $_POST['username'];
		$_SESSION['type'] = $type;
		$insrt->execute();
		echo "Success, you will be redirected to the <a href=\"welcome.php\">main page</a> in 10 seconds.";		
		echo "<meta http-equiv=\"REFRESH\" content=\"10;url=welcome.php\"/>";
	}else{
		$Username = empty($_POST["username"])?"":$_POST["username"];
		echo "<h2>Register</h2>";
		
		echo "<div style=\"background-color:red\">";
		if(empty($_POST["username"])
		or empty($_POST["password"])
		or empty($_POST["confpassword"])
		or empty($_POST["type"]))
			echo "ERROR: All fields are required".
				(empty($_POST["username"])?", Username":"").
				(empty($_POST["password"])?", Password":"").
				(empty($_POST["confpassword"])?", Confirm Password":"").
				(empty($_POST["type"])?", User Type":"").
				"!<br/>";
		elseif($_POST["password"]!=$_POST["confpassword"])
			echo "ERROR: Passwords did not match<br/>";
		elseif((strcmp($_POST["type"], "Student") and strcmp($_POST["type"], "Faculty")))
			echo "Dont be a douche<br/>";
		else{
			$errstr=$insrt->errorInfo();
			if($errstr[0]!=23000)
				echo "Database Error: ".$errstr[0].$errstr[1]."<br/>";
			else
				echo 'Username "'.htmlspecialchars($Username).'" is already registered<br/>';
		}
		echo "</div>";
		echo "<form action=\"register.php\" method=\"post\">";
		echo "<table align=\"center\">";
		echo "<tr><td>Username</td><td><input type=\"text\" name=\"username\" value=\"".htmlspecialchars($Username)."\"/></td></tr>";
		echo "<tr><td>Password</td><td><input type=\"password\" name=\"password\" value=\"\"/></td></tr>";
		echo "<tr><td>Confirm Password</td><td><input type=\"password\" name=\"confpassword\" value=\"\"/></td></tr>";

		echo "<tr><td>Type of User</td><td><select name=\"type\">";
		echo "<option selected=\"selected\"></option>";
		echo "<option>Student</option>";
		echo "<option>Faculty</option>";
		echo "</select></td></tr>";
		echo "<tr><td><input type=\"submit\" name=\"submit\" value=\"Cancel!\"/></td><td><input type=\"submit\" name=\"submit\" value=\"Register!\"/></td></tr>";

		echo "</table></form>";
	}
?>


<?php
	require 'foot.php'; 
?>
