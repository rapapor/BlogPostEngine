<?php
include('dbconnect.php');

if ( isset($_GET['id'])){
	$id= $_GET['id'];
	$statement = $mysqli->prepare("DELETE FROM news WHERE id = ? LIMIT 1");
	$statement->bind_param("i",$id);
	$statement->execute();
	$statement->close();
	header("Location: index.php");
}