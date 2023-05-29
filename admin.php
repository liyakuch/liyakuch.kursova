<?php include('db.php'); 
session_start();
if(isset($_GET["id"]) && $_GET["id"] == $_SESSION["id"]) {

	if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && isset($_GET["out"]) && $_GET["out"] == true) {
		session_unset();
		session_destroy();
		header("Location: index.php");
	}
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
	    // Отримання даних з форми
	    $service = $_POST["service"];
	    $cost = $_POST["cost"];
	    $service_kind = $_POST["service_kind"];

	    // Вставка даних до таблиці services
	    $sql = "INSERT INTO services (service, service_kind, cost) VALUES ('$service', '$service_kind', '$cost')";
	    if (mysqli_query($conn, $sql)) {
	        echo '<div style="margin: 0 auto; text-align: center;">Дані успішно додані до таблиці services.</div>';
	    } else {
	        // Виникла помилка під час вставки даних
	        echo "Сталася помилка при додаванні даних до таблиці services: " . mysqli_error($conn);
	    }
	}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, user-scalable=0">
<title>Адмін панель</title>
<link href="css/style.css" type="text/css" rel="stylesheet">
<link href="css/media.css" type="text/css" rel="stylesheet">
<script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
<div class="site-wrap">
    <div class="wrapper">
		<?php
			echo ('<a href="user.php?id=' . $_SESSION["id"] . '&out=true" class="">Вийти</a>');
		?>
		<h1 class="services-section__title">Адмін панель</h1>
        <h2 class="services-section__title">Наші послуги</h2>
        <div class="services-tabs">
            <div class="services-tabs__nav__wrap">
                <ul class="services-tabs__nav">
                    <?php 
                    // SQL запит з JOIN
                    $sql = "SELECT sk.*, s.service, s.cost, s.id AS services_id FROM services_kind sk LEFT JOIN services s ON sk.id = s.service_kind";
                    $result = mysqli_query($conn, $sql);
                    $service_tabs = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $service_id = $row["id"];
                        $service_name = $row["service_name"];
                        $service = $row["service"];
                        $cost = $row["cost"];
                        $services_id = $row["services_id"];
	                       if (!isset($service_tabs[$service_id])) {
		                        $service_tabs[$service_id] = array(
		                            "name" => $service_name,
		                            "services" => array()
		                        );
		                    }
		                    
		                    if ($service && $cost) {
		                        $service_tabs[$service_id]["services"][] = array(
		                            "name" => $service,
		                            "cost" => $cost,
		                            "id" => $services_id
		                        );
		                    }
		                }
		                
		                $counter = 0;
		                foreach ($service_tabs as $service_id => $service_data) {
		                    $service_name = $service_data["name"];
		                    
		                    if ($counter == 0) {
		                        echo ('<li class="services-tabs__item">
		                                <a href="#tabs-' . $service_id . '" class="services-tabs__link services-tabs__link--active">' . $service_name . '</a>
		                            </li>');
		                    } else {
		                        echo ('<li class="services-tabs__item">
		                                <a href="#tabs-' . $service_id . '" class="services-tabs__link">' . $service_name . '</a>
		                            </li>');
		                    }
		                    
		                    $counter++;
		                }
		                ?>
		            </ul>
		        </div>
		        <div class="services-tabs__contents">
		            <?php 
		            $counter = 0;
		            foreach ($service_tabs as $service_id => $service_data) {
		                $service_name = $service_data["name"];
		                $services = $service_data["services"];
		                
		                echo '<div id="tabs-' . $service_id . '" class="services-tabs__content">
		                        <div class="services-list">';
		                
		                foreach ($services as $service) {
		                    $service_name = $service["name"];
		                    $cost = $service["cost"];
		                    $services_id = $service["id"];
		                    
		                    echo '<div class="services-item">
		                            <div class="services-item__name">' . $service_name . '</div>
		                            <div class="services-item__price"><a href="delete.php?id='. $_SESSION["id"] .'&services_id='. $services_id .'">Видалити</a>| <a href="edit.php?id='. $_SESSION["id"] .'&services_id='. $services_id .'">Редагувати</a>| Від ' . $cost . ' грн.</div>
		                        </div>';
		                }
		                
		                echo '</div>
		                    </div>';
		            }
		            ?>
		        </div>
		    </div>
		</div>
	</div>
	<section>
		<div class="wrapper">
			<div class="admin-layout__center">
				<form action="admin.php?id=<?php echo $_SESSION["id"];?>" method="POST">
				    <div>
				        <input type="text" name="service" class="form-el admin-layout__line" placeholder="Назва послуги" required>
				    </div>
				    <div>
				        <input type="text" name="cost" class="form-el admin-layout__line" placeholder="Вартість" required>
				    </div>
				    <div>
				        <select name="service_kind" id="service_kind" class="form-el" required>
				            <?php
				            $sql = "SELECT id, service_name FROM services_kind";
				            $result = mysqli_query($conn, $sql);
				            while ($row = mysqli_fetch_assoc($result)) {
				                echo '<option value="' . $row["id"] . '">' . $row["service_name"] . '</option>';
				            }
				            ?>
				        </select>
				    </div>
				    <input type="submit" value="Додати" class="btn btn--blue admin-layout__btn">
				</form>
			</div>
		</div>
	</section>
	<section id="reviews-section" class="reviews-section">
		<div class="wrapper">
			<h2 class="services-section__title">Не модеровані відгуки</h2>
					<?php 
						$sql_response = "SELECT u.name, r.*
														FROM users u
														JOIN responses r ON u.id = r.user_id AND moderated = 0";
						$result_response = mysqli_query($conn, $sql_response);
						if(mysqli_num_rows($result_response) > 0){
							while($row_response = mysqli_fetch_assoc($result_response)){
									echo('<div class="reviews-slider__item-wrap">
												<div class="reviews-slider__item">
													<div class="reviews-slider__item__content">
															<div class="reviews-slider__item__name">'. $row_response["name"] .'</div>
															<div class="reviews-slider__item__text" style="margin-bottom: 20px;">'. $row_response["response"] .'</div>
															<a href="moderated.php?id='. $_SESSION["id"] .'&response_id='. $row_response["id"] .'" class="btn">Відмодеровано</a>
															<a href="edit.php?id='. $_SESSION["id"] .'&response_id='. $row_response["id"] .'" class="btn">Редагувати</a>
													</div>
												</div>
										</div>');
							}
						}else {
							echo '<div class="response-info">Усі відгуки відмодеровано</div>';
						}
				?>
		</div>
	</section>
</div>

<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/slick.js"></script>
<script src="js/main.js"></script>

</body>
</html>

<?php }








?>