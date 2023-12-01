<header class="header">
  <nav class="container">
    <div class="nav">
      <div class="row align__items__center justify__content__between">
        <div class="col-5 nav__logo">
          <a href="/admin/index.php"><img class="nav__logo-img" src="/admin/img/logo.png" alt=""></a>
        </div>
        <div class="col-1 mobile__nav">
          <div class="burger-icon">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
          </div>
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
          if (isset($_SESSION['admin_id'])) {
            echo '<a href="/admin/include/admin_logout.php" class="exit__btn">Выйти</a>';
          } else {
            echo '<a href="/admin/pages/authorization.php" class="enter__btn">Войти</a>';
          }
          ?>
        </div>
        <div class="col-12 mobile__nav__menu">
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