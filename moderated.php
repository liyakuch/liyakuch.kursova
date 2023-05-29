<?php include('db.php'); 
session_start();
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && $_GET["id"] == $_SESSION["id"]) {
	$response_id = $_GET["response_id"];
	$sql = "UPDATE `responses` SET `moderated`='1' WHERE `id`='" . $response_id . "'"; // запит на оновлення послуги в таблиці
	$result = mysqli_query($conn, $sql);
	if (mysqli_query($conn, $sql)) {
	  header("Location: admin.php?id=" . $_SESSION['id']); // Перехід на сторінку admin.php
	} else {
	  echo "Помилка оновлення: " . mysqli_error($conn);
	}


}


?>