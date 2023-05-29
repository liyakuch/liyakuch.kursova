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
		<div class="wrapper admin-layout__wrapper">
			<?php
			include('db.php');
			session_start();
			if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && isset($_GET["out"]) && $_GET["out"] == true) {
				session_unset();
				session_destroy();
				header("Location: index.php");
			}
			if (isset($_GET["id"]) && isset($_GET["rules"]) && $_GET["id"] == $_SESSION["id"] && $_GET["rules"] != 1) {

				if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["response"])) {
					$user_id = $_SESSION["id"];
					$response = $_POST["response"];
					$insert_response_query = "INSERT INTO responses (user_id, response) VALUES ('" . $user_id . "', '" . $response . "')";

					if ($conn->query($insert_response_query) === TRUE) {
						echo "Відгук успішно додано!";
					} else {
						echo "Помилка запису відгуку: " . $conn->error;
					}
				}
			}
			?>
			<div class="admin-layout__center">
				<?php
				echo ('<a href="user.php?id=' . $_SESSION["id"] . '&out=true" class="">Вийти</a><br><br><br><br>');
				echo ('Мої відгуки<br><br>');

				$user_id = $_GET["id"];
				$user_info_sql = "SELECT u.id, u.name, r.response
								FROM users u
								JOIN (SELECT user_id, response
									FROM responses
									WHERE user_id = '" . $user_id . "') r ON u.id = r.user_id";
				$result_user_info_sql = mysqli_query($conn, $user_info_sql);
				while ($row = mysqli_fetch_assoc($result_user_info_sql)) {
					$name = $row['name'];
					$response = $row['response'];

					// Виведення імені користувача тільки раз, якщо user_id змінився
					if ($user_id !== $previous_user_id) {
						echo '<div class="user-name">' . $name . '</div>';
					}

					echo '<div class="response">' . $response . '</div><hr>';

					$previous_user_id = $user_id;
				}

				?>
				<div class="admin-layout__title">Залишити відгук</div>
				<?php
				echo ('<form action="user.php?id=' . $_SESSION["id"] . '&rules=0" method="post">
						<input type="text" name="response" class="form-el admin-layout__line" required placeholder="Введіть свій відгук">
						<input type="submit" class="btn btn--blue admin-layout__btn" value="Відправити відгук">
					</form>');
				?>
			</div>
		</div>
	</div>

</body>
</html>