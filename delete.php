<?php include('db.php'); 
session_start();
if(isset($_GET["id"]) && $_GET["id"] == $_SESSION["id"]) {
	if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && $_GET["id"] == $_SESSION["id"] && isset($_GET["services_id"])){
		$sql = "DELETE FROM `services` WHERE id='" . $_GET['services_id'] . "'"; // запит на видалення послуги з таблиці
		$result = mysqli_query($conn, $sql);
		if($result) {
			header("Location: admin.php?id=" . $_SESSION['id']);
		}
	}
}