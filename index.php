<?php include('db.php');?>
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

<div id="modal-forma" class="mfp-hide modal-body__wrap">
  <div class="modal-body">
    <h2 class="modal-title">Замовте дзвінок</h2>
    <form action="form.php" id="modal-forms" class="modal-form">
      <div class="form-line">
        <input type="text" name="name" class="form-el" placeholder="Ваше ім'я">
      </div>
      <div class="form-line">
        <input type="text" name="phone" class="form-el" required placeholder="Номер телефону">
      </div>
      <div class="form-line">
        <input type="submit" class="modal-btn btn btn--blue" value="Відправити">
      </div>
    </form>
  </div>
</div>

<div id="modal-ty" class="mfp-hide modal-body__wrap">
  <div class="modal-body">
    <h2 class="modal-title">Дякуємо</h2>
    <div class="modal-desc">Ми зв'яжемося з вами найближчим часом для уточнення деталей.</div>
  </div>
</div>

<div class="site-wrap">
  <div class="header-mobile">
    <a href="#modal-ty" class="header__modal-ty modal-click">Замовити дзвінок</a>
    <div class="wrapper">
      <div class="header-mobile__inner">
        <div class="header-mobile__left">

        </div>
        <div class="header-mobile__right">
          <div class="header-mobile__right__left">
            <div class="header-mobile__link">
            
            </div>
            <div class="header-mobile__call">

            </div>
          </div>
          <div class="header-mobile__btn">
            <div class="header-mobile__btn-inner">
              <span class="header-mobile__btn-line"></span>
              <span class="header-mobile__btn-line"></span>
              <span class="header-mobile__btn-line"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header-mobile__drop">
      <div class="header-mobile__drop-nav">
        
      </div>
      <div class="header-mobile__drop-link">
        
      </div>
      <div class="header-mobile__drop-call">
        
      </div>
    </div>
  </div>
  <header class="header">
    <div class="wrapper">
      <div class="row header-row">
        <div class="col-3">
          <a href="#main-section" class="logo">
            <span class="logo-text__tc">
              <span class="logo__title"> LEYYKO</span>
            </span>
          </a>
        </div>
        <div class="col-7">
          <nav class="nav">
            <ul class="nav-list">
              <li class="nav-item">
                <a href="#about-section" class="js-nav-trigger nav-link">Про нас</a>
              </li>
              <li class="nav-item">
                <a href="#services-section" class="js-nav-trigger nav-link">Послуги та ціни</a>
              </li>
              <li class="nav-item">
                <a href="#reviews-section" class="js-nav-trigger nav-link">Відгуки</a>
              </li>
              <li class="nav-item">
                <a href="#contacts-section" class="js-nav-trigger nav-link">Контакти</a>
              </li>
              <li class="nav-item">
                <a href="login.php" class="nav-link">Вхід</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-2">
          <div class="header-contacts">
            <div class="contacts-phone">
              <a href="tel:+380980000001" class="contacts-phone__link">098-456-70-01</a>
            </div>
            <div class="header-call">
              <a href="#modal-forma" class="header-call__link modal-click">Замовити дзвінок</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <section id="main-section" class="main-section">
    <div class="wrapper">
        <div class="main-content">
            <div class="main-title"> Косметологічний центр </div>
            <div class="main-text">Краса це – мрія. Здоров’я – необхідність. Наша мета –досягнути цієї гармонії.</div>
            <div class="main-btn__wrap">
                <a href="#modal-forma" class="btn modal-click">Записатись на процедуру</a>
            </div>
        </div>
    </div>
</section>
  <section id="services-section" class="services-section">
    <div class="wrapper">
        <h2 class="services-section__title">Наші послуги</h2>
        <div class="services-tabs">
            <div class="services-tabs__nav__wrap">
                <ul class="services-tabs__nav">
                    <?php 
                    // SQL запит з JOIN
                    $sql = "SELECT sk.*, s.service, s.cost FROM services_kind sk LEFT JOIN services s ON sk.id = s.service_kind";
                    $result = mysqli_query($conn, $sql);
                    $service_tabs = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $service_id = $row["id"];
                        $service_name = $row["service_name"];
                        $service = $row["service"];
                        $cost = $row["cost"];
                        
                        if (!isset($service_tabs[$service_id])) {
                            $service_tabs[$service_id] = array(
                                "name" => $service_name,
                                "services" => array()
                            );
                        }
                        
                        if ($service && $cost) {
                            $service_tabs[$service_id]["services"][] = array(
                                "name" => $service,
                                "cost" => $cost
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
                        
                        echo '<div class="services-item">
                                <div class="services-item__name">' . $service_name . '</div>
                                <div class="services-item__price">Від ' . $cost . ' грн.</div>
                            </div>';
                    }
                    
                    echo '</div>
                        </div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

  <section id="about-section" class="about-section">
    <div class="wrapper">
      <div class="about-block">
        <div class="row about-row">
          <div class="about-block__col__img col-5">
            <div class="about-block__img__wrap">
              <img src="images/about-img.png" class="about-block__img" alt="">
            </div>
          </div>
          <div class="about-block__col__content col-6">
            <div class="about-block__content">
              <h2 class="about-section__title">Про нашу косметологічну клініку</h2>
              <div class="about-section__text">Наш косметологічний центр надає послуги з естетичної, лазерної косметології та лікування шкірних захворювань. Наш салон працює за такими напрямками:

Естетична косметологія. Розмаїття процедур спрямовані на активізацію природної регенерації тканин, усунення недоліків шкіри, корекцію форми губ, омолодження.
Косметологія обличчя включає процедури, що поліпшують стан шкіри: шліфують її поверхню, сприяють виробленню колагену, усувають зморшки та тонізують. Завдяки професійному обладнанню досягти видимого ефекту та позбутися обвислостей повік, зморшок, темних кіл під очима, а також скорегувати контур обличчя можна безопераційними методами.
Косметологія тіла. Масажі, обгортання та стоунтерапія косметології у Львові спрямовані на корекцію контурів тіла, боротьбу із зайвими сантиметрами та целюлітом.
Лазерна косметологія. Терапія сприяє омолодженню шкіри, видаленню рубців, розгладженню поверхні шкіри.
Дерматологічні процедури мають лікувальний ефект та проводяться за призначенням лікаря</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="reviews-section" class="reviews-section">
    <div class="wrapper">
      <h2 class="reviews-title">Відгуки наших пацієнтів</h2>
      <div class="reviews-slider__wrap">
        <div class="reviews-slider">
          <?php 
            $sql_response = "SELECT u.name, r.response
                            FROM users u
                            JOIN responses r ON u.id = r.user_id AND moderated = 1";
            $result_response = mysqli_query($conn, $sql_response);
            while($row_response = mysqli_fetch_assoc($result_response)){
              echo('<div class="reviews-slider__item-wrap">
                      <div class="reviews-slider__item">
                        <div class="reviews-slider__item__content">
                          <div class="reviews-slider__item__name">'. $row_response["name"] .'</div>
                          <div class="reviews-slider__item__text">'. $row_response["response"] .'</div>
                        </div>
                      </div>
                    </div>');
            }
          ?>

        </div>
        <div class="reviews-slider__control">
          <div class="reviews-slider__control__arrow reviews-slider__control__arrow__prev"></div>
          <div class="reviews-slider__control__dots"></div>
          <div class="reviews-slider__control__arrow reviews-slider__control__arrow__next"></div>
        </div>
      </div>
    </div>
  </section>
  <section id="contacts-section" class="contacts-section">
    <div class="contacts-wrapper wrapper">
      <div class="contacts-section__content">
        <h4 class="contacts-section__title">Контакти</h4>
        <ul class="contacts-section__list">
          <li class="contacts-section__item">
            <div class="contacts-section__item-icon">
              <i class="fa fa-contacts__phone"></i>
            </div>
            <div class="contacts-section__item-text">
              <a href="tel:+380000001">098-000-00-01</a>
            </div>
          </li>
          <li class="contacts-section__item">
            <div class="contacts-section__item-icon">
              <i class="fa fa-contacts__email"></i>
            </div>
            <div class="contacts-section__item-text">
              <a href="mailto:test@gmail.com">leyyko@gmail.com</a>
            </div>
          </li>
          <li class="contacts-section__item">
            <div class="contacts-section__item-icon">
              <i class="fa fa-contacts__time"></i>
            </div>
            <div class="contacts-section__item-text">Щоденно<br>з 9:00 до 19:00</div>
          </li>
          <li class="contacts-section__item">
            <div class="contacts-section__item-icon">
              <i class="fa fa-contacts__address"></i>
            </div>
            <div class="contacts-section__item-text">м. Львів, вул. Світла, 25 </div>
          </li>
        </ul>
        <a href="#modal-forma" class="contacts-section__btn btn btn--blue modal-click">Записатись на прийом</a>
      </div>
    </div>
  </section>
  <footer class="footer">
    <div class="wrapper">
      <div class="row header-row">
        <div class="col-3">
          <a href="#main-section" class="logo">
            <span class="logo-text__tc">
              <span class="logo__title"> LEYYKO </span>
            </span>
          </a>
        </div>
        <div class="col-7">
          <nav class="nav">
            <ul class="nav-list">
              <li class="nav-item">
                <a href="#about-section" class="js-nav-trigger nav-link">Про нас</a>
              </li>
              <li class="nav-item">
                <a href="#services-section" class="js-nav-trigger nav-link">Послуги та ціни</a>
              </li>
              <li class="nav-item">
                <a href="#reviews-section" class="js-nav-trigger nav-link">Відгуки</a>
              </li>
              <li class="nav-item">
                <a href="#contacts-section" class="js-nav-trigger nav-link">Контакти</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-2">
          <div class="header-contacts">
            <div class="contacts-phone">
              <a href="tel:+380980000001" class="contacts-phone__link">098-000-00-01</a>
            </div>
            <div class="header-call">
              <a href="#modal-forma" class="header-call__link modal-click">Замовити дзвінок</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>

<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/slick.js"></script>
<script src="js/main.js"></script>

</body>
</html>