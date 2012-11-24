<?php session_start(); ?>
<html>
<body>


<div style="border-style:solid;">

<div style="background-color:gold; height:10%;">

<img src="Buzz-title.png" style="height:100%; float:left"/>
<h1 style="height:100%; display:inline;">Team19Port</h1>
<br/>
<?php
if(isset($_SESSION['user'])){
	echo " <a href=\"welcome.php\">Home</a> ";
if($_SESSION['type']=='D')
	echo " <a href=\"tables.php\">Table Overview</a> ";
	echo " <a href=\"logout.php\">Log out!</a> ";
}
?>
</div>

<div style="float:center; width:100%; text-align:center;">

<?php
$con = new PDO("mysql:host=localhost;dbname=cs4400_Group19","group","hunter2");
if(!$con)
	die("Database error");
?>

<p>
