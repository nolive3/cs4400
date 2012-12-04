<?php
	require 'head.php'; 
?>

<?php
	if(!isset($_SESSION['user']))
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
	else{
		$getusr=$con->prepare("SELECT * FROM RegUser WHERE Username=:user");
		$getusr->bindParam(":user", $_SESSION['user']);
		$getusr->execute();
		if(!($usr = $getusr->fetch()))
			die();
		define('usr', 'usr');
	}
?>
<h1>Personal Info</h1>
<form action="fill-info.php" method="post">
<table align="center">
	<tr>
		<td>
			Name
		</td>
		<td>
			<input type="text" name="Name" <?php echo 'value="'.htmlspecialchars($usr['Name']).'"';?>/>
		</td>
	</tr>
	<tr>
		<td>
			Date of Birth
		</td>
		<td>
			<input type="date" name="DoB" <?php echo 'value="'.htmlspecialchars($usr['DateOfBirth']).'"';?>/>
		</td>
	</tr>
	<tr>
		<td>
			Gender
		</td>
		<td>
			<select name="Gender">
				<option value="M" <?php if($usr['Gender']=='M') echo "selected"; ?> >Male</option>
				<option value="F" <?php if($usr['Gender']=='F') echo "selected"; ?> >Female</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			Address
		</td>
		<td>
			<input type="text" name="address" <?php echo 'value="'.htmlspecialchars($usr['Address']).'"';?>/>
		</td>
	</tr>
	<tr>
		<td>
			Permanent Address
		</td>
		<td>
			<input type="text" name="permaddress" <?php echo 'value="'.htmlspecialchars($usr['PermanentAddress']).'"';?>/>
		</td>
	</tr>
	<tr>
		<td>
			Contact Number
		</td>
		<td>
			<input type="tel" name="contactnum" <?php echo 'value="'.htmlspecialchars($usr['ContactNumber']).'"';?>/>
		</td>
	</tr>
	<tr>
		<td>
			Email Address
		</td>
		<td>
			<input type="email" name="email" <?php echo 'value="'.htmlspecialchars($usr['Email']).'"';?>/>
		</td>
	</tr>

	<tr>
		<td>
			<input type="submit" value="GO!"/>
		</td>
		<td>
			<input formaction="welcome.php" type="submit" value="cancel"/>
		</td>
	</tr>
</table>
</form>

<?php
	require 'foot.php'; 
?>
