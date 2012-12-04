<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
	if(!RegUserInfoComplete($con)){
		$finalize = $con->prepare("INSERT INTO Faculty(Username, Dept_Id) VALUE (:u, 'AE')");
		$finalize->bindParam(':u', $_SESSION['user']);
		if(!$finalize->execute()){
			die('Faculty creation problem');
		}
		$finalize->closeCursor();
	}
	$finalize = $con->prepare("SELECT Dept_Id, Position FROM Faculty WHERE Username=:u");
	$finalize->bindParam(':u', $_SESSION['user']);
	$finalize->bindColumn('Dept_Id', $deptid);
	$finalize->bindColumn('Position', $pos);
	if(!$finalize->execute()){
		die('execute problem');
	}
	if(!$finalize->fetch()){
		die('fetch problem');
	}
	$finalize->closeCursor();
?>
<h1>Faculty Info</h1>
<form action="fill-faculty-info.php" method="post">
<table align="center">
	<tr>
		<td>
			Department
		</td>
		<td>
			<select name="Department">
				<?php
					$dep = $con->prepare('SELECT Dept_Id, Name FROM Department');
					$dep->bindColumn('Dept_Id', $dept);
					$dep->bindColumn('Name', $name);
					$dep->execute();
					while($dep->fetch()){
						echo '<option value="'.htmlspecialchars($dept).'">'.htmlspecialchars($name).'</option>';
					}
					$dep->closeCursor();
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			Position
		</td>
		<td>
			<select name="Position">
				<option value="Professor" <?php echo $pos=='Professor'?'selected':''; ?>>Professor</option>
				<option value="Associate Professor" <?php echo $pos=='Associate Professor'?'selected':''; ?>>Associate Professor</option>
				<option value="Assistant Professor" <?php echo $pos=='Assistant Professor'?'selected':''; ?>>Assistant Professor</option>
			</select>
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
