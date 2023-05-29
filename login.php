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
<?php include('db.php'); 


?>


<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Перевірка, якщо форма була відправлена

	// Отримання даних з форми
	$login = $_POST["login"];
	$name = $_POST["name"];
	$password = $_POST["password"];
	$is_signup = isset($_POST["is_signup"]) && $_POST["is_signup"] == "on";

	// Виконання необхідної обробки в залежності від того, чи це реєстрація чи вхід
	if ($is_signup) {
		 // Логіка реєстрації користувача

		// Перевірка, чи існує користувач з таким логіном
		$check_user_query = "SELECT * FROM users WHERE login = '". $login ."'";
		$check_user_result = $conn->query($check_user_query);

		if ($check_user_result->num_rows > 0) {
			echo "Користувач з таким логіном вже існує!";
		} else {
			// Вставка нового користувача в базу даних
			$insert_user_query = "INSERT INTO users (login, password, name) VALUES ('". $login ."', '". $password ."', '". $name. "')";

			if ($conn->query($insert_user_query) === TRUE) {
                echo "Ви успішно зареєстровані, тепер увійдіть"; 
			} else {
				echo "Помилка реєстрації користувача: " . $conn->error;
			}
		}
	} else {
		// Логіка входу користувача

		// Перевірка коректності введених даних
		$check_login_query = "SELECT * FROM users WHERE login = '". $login ."' AND password = '". $password ."'";
		$check_login_result = $conn->query($check_login_query);

		if ($check_login_result->num_rows > 0) {
			// Успішний вхід

			// Отримання ID користувача
			$user_row = $check_login_result->fetch_assoc();
			$user_id = $user_row["id"];
			$user_rules = $user_row["rules"];
			// Запис ID користувача в сесію
			$_SESSION["id"] = $user_id;
			if($user_rules == 0){
				// Перехід на сторінку user.php з передачею ID через параметр
				header("Location: user.php?id=". $user_id ."&rules=". $user_rules);
			}else {
				// Перехід на сторінку admin.php з передачею ID через параметр
				header("Location: admin.php?id=". $user_id);
			}
			exit();
		} else {
			echo "Неправильний логін або пароль!";
		}
	}
}


?>

<div class="admin-layout">
	<div class="wrapper admin-layout__wrapper">
		<div class="admin-layout__center">
			<div class="admin-layout__title">Форма входу</div>
			<form action="login.php" method="post">
				<input type="text" name="login" class="form-el admin-layout__line" placeholder="Ваш логін" required>
				<input type="text" name="name" class="form-el admin-layout__line" placeholder="Ваш прізвище та імя" required>
				<input type="password" name="password" class="form-el admin-layout__line" placeholder="Ваш пароль" required>
				<label>
					<input type="checkbox" id="is_signup" class="checkbox-auto" name="is_signup">
					Зареєструватись
				</label>
				<input type="submit" class="btn btn--blue admin-layout__btn" value="Відправити">
			</form>
		</div>
	</div>
</div>

</body>
</html>
