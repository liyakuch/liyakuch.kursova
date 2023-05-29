<?php include('db.php'); 
session_start();
if(isset($_GET["id"]) && $_GET["id"] == $_SESSION["id"]) {
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"]) && $_GET["id"] == $_SESSION["id"] && isset($_GET["services_id"])){
		$services_id = $_POST["services_id"];
		$service = $_POST["service"];	
		$cost = $_POST["cost"];			
		$sql_response = "UPDATE `services` SET `service`=?, `cost`=? WHERE `id`=?";
		$stmt = $conn->prepare($sql_response);
		if (!$stmt) {
		    echo "Помилка підготовки запиту: " . $conn->error;
		    exit();
		}
		// Прив'язка параметрів та виконання запиту
		$stmt->bind_param("sss", $service, $cost, $services_id);
		if (!$stmt->execute()) {
		    echo "Помилка виконання запиту: " . $stmt->error;
		    exit();
		}else{

			header("Location: admin.php?id=" . $_SESSION['id']);
		}
	}
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["response"]) && isset($_POST["response_id"])){
		$response_id = $_POST["response_id"];
		$response = $_POST["response"];
		$sql_response = "UPDATE `responses` SET `response`=?, `moderated`='1' WHERE `id`=?";
		$stmt = $conn->prepare($sql_response);
		if (!$stmt) {
		    echo "Помилка підготовки запиту: " . $conn->error;
		    exit();
		}
		// Прив'язка параметрів та виконання запиту
		$stmt->bind_param("si", $response, $response_id);
		if (!$stmt->execute()) {
		    echo "Помилка виконання запиту: " . $stmt->error;
		    exit();
		}else{

			header("Location: admin.php?id=" . $_SESSION['id']);
		}
	}

	$response_id = $_GET["response_id"];
	$edited_response = "SELECT * FROM `responses` WHERE `id`='". $response_id ."'";
	$result_edited = mysqli_query($conn, $edited_response);
	$result_row = $result_edited->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, user-scalable=0">
<title>Radiant</title>
<link href="css/style.css" type="text/css" rel="stylesheet">
<link href="css/media.css" type="text/css" rel="stylesheet">
<script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
	<div class="admin-layout">
		<div class="admin-layout__center">
<?php

	if(isset($_GET["id"]) && $_GET["id"] == $_SESSION["id"] && isset($_GET["response_id"])){
	echo('<form action="edit.php?id='. $_SESSION["id"] .'" method="post">
			<textarea name="response" cols="55" rows="15" class="form-el admin-layout__line">'. $result_row["response"] .'</textarea>
			<input type="hidden" name="response_id" value="'. $response_id .'">
			<input type="submit" class="btn btn--blue admin-layout__btn" value="Редагувати">
		</form>');
	}
	if(isset($_GET["id"]) && $_GET["id"] == $_SESSION["id"] && isset($_GET["services_id"])){
		$services_id = $_GET["services_id"];
		$edited_service = "SELECT * FROM `services` WHERE `id`='". $services_id ."'";
		$result_service = mysqli_query($conn, $edited_service);
		$result_row = $result_service->fetch_assoc();
		echo('<form action="edit.php?id='. $_SESSION["id"] .'&services_id='. $services_id .'" method="post">
				<input type="text" name="service" class="form-el admin-layout__line" value="'. $result_row["service"] .'">				
				<input type="text" name="cost" class="form-el admin-layout__line" value="'. $result_row["cost"] .'">
				<input type="hidden" name="services_id" class="form-el admin-layout__line" value="'. $services_id .'">
				<input type="submit" class="btn btn--blue admin-layout__btn" value="Редагувати">
			</form>');
	}

}

?>		

	</div>
</body>
</html>