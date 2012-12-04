<?php
	require 'head.php'; 
	if(!isset($_SESSION['user'])){
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=index.php\"/>";
		die('user not set, redirecting');	
	}
	if(!RegUserInfoComplete($con)){
		$finalize = $con->prepare("INSERT INTO Student(Username) VALUE (:u)");
		$finalize->bindParam(':u', $_SESSION['user']);
		$finalize->execute();
		$finalize->closeCursor();
	}
	$finalize = $con->prepare("SELECT Major, Degree FROM Student WHERE Username=:u");
	$finalize->bindParam(':u', $_SESSION['user']);
	$finalize->bindColumn('Major', $deptid);
	$finalize->bindColumn('Degree', $degr);
	$finalize->execute();
	if(!$finalize->fetch()){
		die('fetch error');
	}
	$finalize->closeCursor();
?>
<h1>Student info</h1>

<form action="fill-student-info.php" method="post">
<table align="center">
	<tr>
		<td>
			Major
		</td>
		<td>
			<select name="Department">
				<?php
					$dep = $con->prepare('SELECT Dept_Id, Name FROM Department');
					$dep->bindColumn('Dept_Id', $dept);
					$dep->bindColumn('Name', $name);
					$dep->execute();
					while($dep->fetch()){
						echo '<option value="'.htmlspecialchars($dept).'" '.($dept==$deptid?'selected':'').'>'.htmlspecialchars($name).'</option>';
					}
					$dep->closeCursor();
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			Degree
		</td>
		<td>
			<select name="Degree">
				<option value="BS" <?php echo $degr=='BS'?'selected':''; ?>>BS</option>
				<option value="MS" <?php echo $degr=='MS'?'selected':''; ?>>MS</option>
				<option value="Ph.D" <?php echo $degr=='Ph.D'?'selected':''; ?>>Ph.D</option>
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
