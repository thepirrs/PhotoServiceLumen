<header class="header">
  <nav class="container">
    <div class="nav">
      <div class="row align__items__center justify__content__between">
        <div class="col-1 nav__logo">
          <a href="/index.php"><img class="nav__logo-img" src="/img/logo.png" alt=""></a>
        </div>
        <div class="col-1 mobile__nav">
          <div class="burger-icon">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
          </div>
        </div>
        <div class="col-4 nav__menu">
          <ul class="nav__list">
            <li class="nav__item"><a class="nav__link" href="/index.php">Главная</a></li>
            <li class="nav__item"><a class="nav__link" href="/pages/account.php">Личный кабинет</a></li>
            <li class="nav__item"><a class="nav__link" href="/pages/portfolio.php">Мое портфолио</a></li>
          </ul>
        </div>

        <div class="col-6 nav__find">



          <?php
          echo '<form class="findform" method="POST" action="#">';
          echo '<input type="text" class="form-control" id="photographerSearch" name="searchName" placeholder="Введите имя и фамилию фотографа">';
          echo '<button class="nav__find__btn">Найти</button>';
          $query = "SELECT DISTINCT city FROM users";
          $result = $mysqli->query($query);

          if ($result) {
            echo '<form method="POST" action="#">';
            echo '<select class="nav__select__city" name="selectedCity" onchange="this.form.submit();">';
            echo '<option value="all" ' . ($_POST['selectedCity'] === 'all' ? 'selected' : '') . '>Выбрать город</option>';

            while ($row = $result->fetch_assoc()) {
              $city = $row['city'];
              $selected = ($city === $_POST['selectedCity']) ? 'selected' : '';
              echo '<option ' . $selected . '>' . $city . '</option>';
            }

            echo '</select>';


            $result->close();
          } else {
            echo 'Ошибка при выполнении SQL-запроса: ' . $mysqli->error;
          }
          echo '</form>';
          ?>
        </div>

        <div class="col-1 nav__account">
          <?php
          if (isset($_SESSION['user_id'])) {
            echo '<a href="/include/user_logout.php" class="exit__btn">Выйти</a>';
          } else {
            echo '<a href="/pages/authorization.php" class="enter__btn">Войти</a>';
          }
          ?>
        </div>
        <div class="col-12 mobile__nav__menu">
          <ul class="mobile__menu">
            <li><a href="/index.php">Главная</a></li>
            <li><a href="/pages/account.php">Личный кабинет</a></li>
            <li><a href="/pages/portfolio.php">Мое портфолио</a></li>
          </ul>
          <div class="col-12 navmobile__find">
            <?php
            echo '<form class="findform" method="POST" action="#">';
            echo '<input type="text" class="form-control" id="photographerSearch" name="searchName" placeholder="Введите имя и фамилию фотографа">';
            echo '<button class="nav__find__btn">Найти</button>';
            $query = "SELECT DISTINCT city FROM users";
            $result = $mysqli->query($query);

            if ($result) {
              echo '<form method="POST" action="#">';
              echo '<select class="nav__select__city" name="selectedCity" onchange="this.form.submit();">';
              echo '<option value="all" ' . ($_POST['selectedCity'] === 'all' ? 'selected' : '') . '>Выбрать город</option>';

              while ($row = $result->fetch_assoc()) {
                $city = $row['city'];
                $selected = ($city === $_POST['selectedCity']) ? 'selected' : '';
                echo '<option ' . $selected . '>' . $city . '</option>';
              }

              echo '</select>';


              $result->close();
            } else {
              echo 'Ошибка при выполнении SQL-запроса: ' . $mysqli->error;
            }
            echo '</form>';
            ?>
          </div>
        </div>
      </div>
    </div>


  </nav>
</header>