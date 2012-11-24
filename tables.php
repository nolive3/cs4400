<?php
	require 'head.php'; 
?>

<?php
	function f($cell, $ind, $row){
		echo "<td>".htmlspecialchars($row[$cell])."</td>";
	}
	$tables = $con->query('SHOW TABLES;');
	$tables->bindColumn(1,$table);
	while($tables->fetch()){
		echo "<h3 style=\"inline\">";
		echo htmlspecialchars($table);
		echo "</h3><table align=\"center\" border=\"1\">";
		echo "<tr>";
		$des = $con->query('DESCRIBE '.$table.';');
		$desc=array();
		while($d=$des->fetch()){
			echo "<th>".htmlspecialchars(current($d))."</th>";
			array_push($desc, current($d));
		}
		$des->closeCursor();
		echo "</tr>";
		$vals = $con->query('SELECT * FROM '.$table.';');
		while($d=$vals->fetch()){
			echo "<tr>";
			array_walk($desc, 'f', $d);
			echo "</tr>";
		}
		$vals->closeCursor();
		echo "</table>";
	}
	$tables->closeCursor();
?>

<?php
	require 'foot.php'; 
?>
