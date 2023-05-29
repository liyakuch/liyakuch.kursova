<?php


	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = $_POST["name"];
		$phone = $_POST["phone"];
		$to = "test@gmail.com";
		$subject = "Заявка косметологічний центр";
		$message = "Ім'я: $name\nТелефон: $phone";
		$headers = "From: test@gmail.com\r\nReply-To: test@gmail.com";
		mail($to, $subject, $message, $headers);
	}

	
?>