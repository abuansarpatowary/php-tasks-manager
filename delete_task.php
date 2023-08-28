<?php
include_once 'config.php';
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Delete task
if (isset($_GET['id'])) {
	$id = $_GET['id'];

	$deleteQuery = "DELETE FROM " . DB_TABLE . " WHERE id = $id";
	mysqli_query($connection, $deleteQuery);

	header("Location: index.php");
	exit();
}
?>
