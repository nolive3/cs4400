<?php
	require 'head.php'; 
?>

<?php
	if(isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";
?>

<?php 
	if(!isset($_POST["submit"]))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
	else
		switch($_POST["submit"])
		{
		case "Log In!":
	#Logging in
			if($_POST["submit"]=="Cancel!"){
				echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
			}elseif(isset($_POST["username"]) and isset($_POST["password"])){
				$res=$con->prepare("SELECT Username, Type FROM User WHERE Username=:name AND Password=:pass;");
				$res->bindParam(':name', $_POST['username']);
				$res->bindParam(':pass', $_POST['password']);
				$res->bindColumn('Username', $user);
				$res->bindColumn('Type', $type);
				$res->execute();
				if($res->fetch()){
					$_SESSION['user'] = $user;
					$_SESSION['type'] = $type;
					$res->closeCursor();
					echo "<meta http-equiv=\"REFRESH\" content=\"0;url=welcome.php\"/>";

				}else{
					echo "<meta http-equiv=\"REFRESH\" content=\"0;url=login.php\"/>";
				}
			}else{
	#login form
				$Username=isset($Username)?$Username:"";
				echo "<h2>Log In<h2>";
				echo "<form action=\"login.php\" method=\"post\">";
				echo "<table align=\"center\">";
				echo "<tr><td>Username</td><td><input type=\"text\" name=\"username\" value=\"".htmlspecialchars($Username)."\"/></td></tr>";
				echo "<tr><td>Password</td><td><input type=\"password\" name=\"password\" value=\"\"/></td></tr>";
				echo "<tr><td><input type=\"submit\" name=\"submit\" value=\"Log In!\"/></td><td><input type=\"submit\" name=\"submit\" value=\"Register!\"/></td></tr>";
				echo "</table>";
				echo "</form>";
			}
			break;



	#Done logging in
		case "Register!":


	#Registration
		

	#registration form
			$Username = empty($_POST["username"])?"":$_POST["username"];
			echo "<h2>Register</h2>";
			echo "All fields are required<br/>";
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
			break;

	#done registration
		default:


	#something
			echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		}
?><br />
<?php
	require 'foot.php'; 
?>
