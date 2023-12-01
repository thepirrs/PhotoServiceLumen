<?php include('../include/db_connect.php') ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<?php
if (!isset($_SESSION["user_id"])) {
  header("Location: /pages/authorization.php");
  exit();
}
?>

<?php
$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $mysqli->query($sql);

if ($result) {
  $user_data = $result->fetch_assoc();
}
?>

<?php
$user_id = $_SESSION["user_id"];

$sql = "UPDATE users 
        SET photographer = (
            SELECT IF(COUNT(*) >= 3 AND EXISTS (SELECT 1 FROM services WHERE user_id = $user_id), 1, 0) 
            FROM portfolio 
            WHERE user_id = $user_id
        )
        WHERE user_id = $user_id";

if ($mysqli->query($sql)) {
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Личный кабинет</title>
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/setka.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/profile.css">
  <link rel="stylesheet" href="/css/account.css">
</head>

<body>

  <?php include('../include/menu.php') ?>

  <section class="account">

    <div class="container">
      <div class="row justify__content__center">

        <div class="col-10 account__block">

          <div class="col-2 account__block__menu">
            <div class="left__block">
              <div class="account__btn">
                <button class="account__button" id="showDescription">Профиль</button>
                <button class="account__button" id="showServices">Услуги</button>
                <button class="account__button" id="showReviews">Отзывы</button>
              </div>
              <div class="account__stat">
                <?php
                $queryAverageRating = "SELECT ROUND(IFNULL(AVG(rating), 0), 1) AS avg_rating FROM reviews WHERE user_id = $user_id";
                $resultAverageRating = $mysqli->query($queryAverageRating);
                $rowAverageRating = $resultAverageRating->fetch_assoc();

                if ($rowAverageRating) {
                  $averageRating = $rowAverageRating['avg_rating'];

                  echo '<div class="account__mark">';
                  echo '<div><p class="mark__value">' . $averageRating . '</p></div>';
                  echo '<div><p class="mark__name">Рейтинг</p></div>';
                  echo '</div>';
                }
                ?>
                <?php
                $queryReviewCount = "SELECT COUNT(*) AS review_count FROM reviews WHERE user_id = " . $_SESSION["user_id"];
                $resultReviewCount = $mysqli->query($queryReviewCount);
                $rowReviewCount = $resultReviewCount->fetch_assoc();

                if ($rowReviewCount) {
                  $reviewCount = $rowReviewCount['review_count'];

                  echo '<div class="account__mark">';
                  echo '<div><p class="mark__value">' . $reviewCount . '</p></div>';
                  echo '<div><p class="mark__name">Отзывы</p></div>';
                  echo '</div>';
                }
                ?>
                <?php
                //$queryMinPrice = "SELECT IFNULL(MIN(price), 0) AS min_price FROM Services WHERE user_id = " . $_SESSION["user_id"];
                //$resultMinPrice = $mysqli->query($queryMinPrice);
                //$rowMinPrice = $resultMinPrice->fetch_assoc();

                //if ($rowMinPrice) {
                //  $minPrice = $rowMinPrice['min_price'];
                //  echo '<div class="account__mark">';
                //  echo '<div><p class="mark__value">' . $minPrice . ' Р</p></div>';
                //  echo '<div><p class="mark__name">Стоимость</p></div>';
                //  echo '</div>';
                //}
                ?>

                <div class="account__mark">
                  <div>
                    <p class="mark__value"><span class="min__price_value">0 Р</span></p>
                  </div>
                  <div>
                    <p class="mark__name">Стоимость</p>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="col-10 account__block__main">

            <div class="account__description" id="description">
              <div class="account__photo">
                <?php
                $user_id = $_SESSION["user_id"];
                $getImageQuery = "SELECT avatar FROM users WHERE user_id = $user_id";
                $result = $mysqli->query($getImageQuery);

                if ($result) {
                  $row = $result->fetch_assoc();
                  $avatarPath = $row['avatar'];

                  if (!empty($avatarPath)) {
                    echo '<img class="account__img" src="/' . $avatarPath . '" alt="User Avatar">';
                  } else {
                    echo '<img class="account__img" src="/img/defavatar.png" alt="User Avatar">';
                  }
                }
                ?>
                <button class="editphoto__btn" id="openModal">Изменить фото</button>
                <div class="modal" id="photoModal">
                  <div class="modal-content">
                    <span class="close" id="closeModal">&#10006;</span>
                    <form method="post" enctype="multipart/form-data">
                      <input type="submit" value="Загрузить" class="addphoto__btn">
                      <label for="profile_image" class="custom-file-upload">
                        <input type="file" name="profile_image" id="profile_image" accept="image/*">
                      </label>
                    </form>
                  </div>
                </div>


                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_image"])) {
                  $user_id = $_SESSION["user_id"];

                  $uploadDirectory = "../uploads/";
                  $targetFile = $uploadDirectory . basename($_FILES["profile_image"]["name"]);

                  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                  $allowedExtensions = array("jpg", "jpeg", "png", "gif");

                  if (in_array($imageFileType, $allowedExtensions)) {

                    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {

                      $updateImageQuery = "UPDATE users SET avatar = ? WHERE user_id = ?";
                      $stmt = $mysqli->prepare($updateImageQuery);
                      $stmt->bind_param("si", $targetFile, $user_id);

                      if ($stmt->execute()) {
                        echo '<script>window.location = "account.php";</script>';
                        exit();
                      } else {
                        echo "Ошибка при обновлении фотографии профиля.";
                      }
                    } else {
                      echo "Ошибка при загрузке файла.";
                    }
                  } else {
                    echo "Допустимы только изображения с расширениями: jpg, jpeg, png, gif.";
                  }
                }
                ?>
              </div>

              <?php
              if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['save'])) {

                  if (isset($_SESSION['user_id'])) {

                    $city = $_POST['city'];
                    $city = mysqli_real_escape_string($mysqli, $city);

                    $name = $_POST['name'];
                    $name = mysqli_real_escape_string($mysqli, $name);

                    $surname = $_POST['surname'];
                    $surname = mysqli_real_escape_string($mysqli, $surname);

                    $description = $_POST['description'];
                    $description = mysqli_real_escape_string($mysqli, $description);

                    $telephone = $_POST['telephone'];
                    $telephone = mysqli_real_escape_string($mysqli, $telephone);

                    $email = $_POST['email'];
                    $email = mysqli_real_escape_string($mysqli, $email);

                    $socinst = $_POST['socinst'];
                    $socinst = mysqli_real_escape_string($mysqli, $socinst);

                    $socvk = $_POST['socvk'];
                    $socvk = mysqli_real_escape_string($mysqli, $socvk);

                    $soctg = $_POST['soctg'];
                    $soctg = mysqli_real_escape_string($mysqli, $soctg);

                    $sql = "UPDATE users SET city='$city', name='$name', surname='$surname', description='$description', telephone='$telephone', email='$email', socinst='$socinst', socvk='$socvk', soctg='$soctg' WHERE user_id={$_SESSION['user_id']}";
                    if (mysqli_query($mysqli, $sql)) {
                      echo '<script>window.location = "account.php";</script>';
                      exit();
                    } else {
                      echo 'Ошибка обновления данных: ' . mysqli_error($mysqli);
                    }
                  }
                }
              }
              ?>
              <form method="post">

                <div class="account__city">
                  <label class="services__name">Город</label>
                  <textarea name="city" class="accountinfo__text"><?= $user_data['city'] ?></textarea>
                </div>


                <div class="account__name">
                  <div class="form-group">
                    <label class="services__name">Имя</label>
                    <textarea name="name" class="accountinfo__text"><?= $user_data['name'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <label class="services__name">Фамилия</label>
                    <textarea name="surname" class="accountinfo__text"><?= $user_data['surname'] ?></textarea>
                  </div>
                </div>

                <div class="account__about">
                  <label class="services__name">О себе</label>
                  <textarea name="description" class="accountinfo__abouttext"><?= $user_data['description'] ?></textarea>
                </div>

                <div class="account__contact">
                  <div class="form-group">
                    <label class="services__name">Телефон</label>
                    <textarea name="telephone" class="accountinfo__text"><?= $user_data['telephone'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <label class="services__name">Почта</label>
                    <textarea name="email" class="accountinfo__text"><?= $user_data['email'] ?></textarea>
                  </div>
                </div>

                <div class="account__social">
                  <label class="services__name">Социальные сети</label>
                  <div class="form-group">
                    <textarea name="soctg" class="accountsoc__text" placeholder="@telegram"><?= $user_data['soctg'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <textarea name="socvk" class="accountsoc__text" placeholder="@vk"><?= $user_data['socvk'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <textarea name="socinst" class="accountsoc__text" placeholder="@instagram"><?= $user_data['socinst'] ?></textarea>
                  </div>
                </div>

                <div class="profile__styles">
                  <div class="services__name">Жанры:</div>
                  <div class="account__styles__items">
                    <?php
                    $user_id = $_SESSION["user_id"];
                    $genreQuery = "SELECT g.genre_name
                    FROM genres g
                    JOIN photographergenres pg ON g.genre_id = pg.genre_id
                    WHERE pg.user_id = $user_id";

                    $result = $mysqli->query($genreQuery);

                    echo '<div class="account__styles__items">';
                    while ($row = $result->fetch_assoc()) {
                      echo '<div class="account__styles__item">' . $row["genre_name"] . '</div>';
                    }
                    echo '</div>';
                    ?>
                  </div>
                  <div class="profile__styles__items">
                    <?php
                    $sql = "SELECT * FROM genres";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {

                      while ($row = $result->fetch_assoc()) {
                        echo '<div class="profile__styles__item" data-genre="' . $row["genre_name"] . '">' . $row["genre_name"] . '</div>';
                      }
                    } else {
                      echo "Нет доступных жанров.";
                    }

                    ?>

                    <?php
                    if (isset($_POST['savegenres'])) {

                      $selectedGenres = isset($_POST['selectedGenres']) ? $selectedGenres = $_POST['selectedGenres'] : [];
                      $user_id = $_SESSION["user_id"];


                      $deleteQuery = "DELETE FROM photographergenres WHERE user_id = $user_id";
                      $mysqli->query($deleteQuery);

                      $selectedGenresArray = explode(", ", $selectedGenres);


                      foreach ($selectedGenresArray as $genreName) {
                        $genreName = $mysqli->real_escape_string($genreName);
                        $selectGenreIdQuery = "SELECT genre_id FROM genres WHERE genre_name = '$genreName'";
                        $result = $mysqli->query($selectGenreIdQuery);
                        if ($result) {
                          $row = $result->fetch_assoc();
                          $genre_id = $row['genre_id'];

                          if ($genre_id) {
                            $insertQuery = "INSERT INTO photographergenres (user_id, genre_id) VALUES ($user_id, $genre_id)";
                            $mysqli->query($insertQuery);
                          }
                        }
                      }

                      $mysqli->close();
                      echo '<script>window.location = "account.php";</script>';
                      exit();
                    }
                    ?>
                  </div>
                </div>

                <div class="account__btnstatus">
                  <input type="hidden" name="selectedGenres" id="selectedGenresField">
                  <button type="submit" name="save" class="newsevices__button">Сохранить профиль</button>
                  <button type="submit" name="savegenres" class="newsevices__button">Сохранить жанры</button>
                </div>


              </form>
            </div>

            <div class="account__services" id="services">
              <div class="account__addservices">
                <h2 class="account__services__title">Новая услуга</h2>
                <form id="addServiceForm">
                  <label class="services__name">Название услуги</label>
                  <textarea name="serviceName" class="newservices__text"></textarea>
                  <label class="services__name">Описание</label>
                  <textarea name="description" class="newservices__text"></textarea>
                  <label class="services__name">Стоимость</label>
                  <textarea name="price" class="newservices__text"></textarea>
                  <div class="newsevices__btn">
                    <button type="button" id="addServiceButton" class="newsevices__button">Добавить</button>
                  </div>
                </form>
              </div>


              <div class="account__services" id="servicesContainer">
                <h2 class="account__services__title">Мои услуги</h2>

              </div>
              <div class="col-12 pagination" id="pagination__services">
              </div>
              <?php
              $user_id = $_SESSION["user_id"];

              $query = "SELECT COUNT(*) as totalItems FROM services WHERE user_id = $user_id";

              $result = $mysqli->query($query);

              if ($result) {
                $row = $result->fetch_assoc();
                $totalItems = $row['totalItems'];
              } else {
                die("Ошибка при выполнении запроса: " . $mysqli->error);
              }
              ?>
            </div>


            <div class="account__reviews" id="reviews">
              <?php
              $user_id = $_SESSION["user_id"];

              $queryReviews = "SELECT r.rating, r.review_text, u.name, u.surname, u.avatar
                    FROM reviews r
                    JOIN users u ON r.review_user_id = u.user_id
                    WHERE r.user_id = $user_id
                    ORDER BY r.review_id DESC";

              $resultReviews = $mysqli->query($queryReviews);

              if ($resultReviews && $resultReviews->num_rows > 0) {
                while ($row = $resultReviews->fetch_assoc()) {
                  $rating = $row["rating"];
                  $review_text = $row["review_text"];
                  $reviewer_name = $row["name"] . " " . $row["surname"];
                  $reviewer_avatar = $row["avatar"];
              ?>
                  <div class="col-12 reviews__item">
                    <div class="reviews__title">
                      <div class="reviews__name">
                        <div class="reviews__avatar"><img class="client__avatar" src="/<?php echo $reviewer_avatar; ?>" alt="Аватар пользователя"></div>
                        <div class="client__name"><?php echo $reviewer_name; ?></div>
                      </div>
                      <div class="reviews__grade">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                          $starClass = $i <= $rating ? "grade__stars active" : "grade__stars";
                          echo '<div class="client__grade"><img class="' . $starClass . '" src="/img/star0.png" alt=""></div>';
                        }
                        ?>
                      </div>
                    </div>
                    <div class="reviews__text">
                      <?php echo $review_text; ?>
                    </div>
                  </div>

              <?php
                }
              } else {
                echo '<p class="notification">У вас пока нет отзывов</p>';
              }
              ?>

              <?php
              $user_id = $_SESSION["user_id"];
              $query = "SELECT COUNT(*) as totalItemsReviews FROM reviews WHERE user_id = $user_id";

              $result = $mysqli->query($query);

              if ($result) {
                $row = $result->fetch_assoc();
                $totalItemsReviews = $row['totalItemsReviews'];
              } else {
                die("Ошибка при выполнении запроса: " . $mysqli->error);
              }
              ?>
              <div class="col-12 pagination" id="pagination__reviews"></div>
            </div>

          </div>
        </div>

      </div>
    </div>


  </section>





  <?php include('../include/footer.php') ?>





  <script src="/js/code.jquery.com_jquery-3.7.0.min.js"></script>
  <script src="/js/jquery-pagination.js"></script>

  <script>
    if ($(document).height() <= $(window).height()) {
      $(".footer").addClass("fixed-bottom");
    }
  </script>

  <script>
    $(document).ready(function() {

      updateServicesBlock();

      updateMinPriceBlock();


      $("#addServiceButton").click(function() {
        $.ajax({
          type: "POST",
          url: "/include/ajax/add_service.php",
          data: $("#addServiceForm").serialize() + "&saveservice=1",
          success: function(response) {
            if (response === "success") {

              $("#addServiceForm")[0].reset();

              updateServicesBlock();
              updateMinPriceBlock();
            } else {
              console.error(response);
            }
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при добавлении услуги: " + error);
          }
        });
      });


      window.deleteService = function(serviceId) {
        $.ajax({
          type: "POST",
          url: "/include/ajax/delete_service.php",
          data: {
            service_id: serviceId,
            deleteService: true
          },
          success: function(response) {
            if (response.trim() === "success") {

              updateServicesBlock();
              updateMinPriceBlock();
            } else {
              console.error(response);
            }
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при удалении услуги: " + error);
          }
        });
      };


      function updateServicesBlock() {
        $("#servicesContainer").load("/include/ajax/get_services.php");
      }

      function updateMinPriceBlock() {
        $.ajax({
          type: "GET",
          url: "/include/ajax/get_min_price.php",
          success: function(minPrice) {

            $(".min__price_value").text(minPrice + " Р");
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при получении минимальной стоимости: " + error);
          }
        });
      }
    });
  </script>

  <script>
    $(document).ready(function() {

      $("#reviews").hide();
      $("#services").hide();
      $("#description").show();


      $("#showDescription").click(function() {
        $("#reviews").hide();
        $("#services").hide();
        $("#description").show();
        $(".footer").removeClass("fixed-bottom");
        return false;
      });

      $("#showServices").click(function() {
        $("#description").hide();
        $("#reviews").hide();
        $("#services").show();
        $(".footer").addClass("fixed-bottom");
        return false;
      });

      $("#showReviews").click(function() {
        $("#description").hide();
        $("#services").hide();
        $("#reviews").show();
        $(".footer").addClass("fixed-bottom");
        return false;
      });
    });
  </script>

  <script>
    document.getElementById('openModal').addEventListener('click', function() {
      document.getElementById('photoModal').style.display = 'flex';
    });

    document.getElementById('closeModal').addEventListener('click', function() {
      document.getElementById('photoModal').style.display = 'none';
    });

    document.getElementById('uploadButton').addEventListener('click', function() {
      document.getElementById('photoModal').style.display = 'none';
    });
  </script>

  <script>
    var profileItems = document.querySelectorAll(".profile__styles__item");
    var selectedGenres = [];


    profileItems.forEach(function(item) {
      item.addEventListener("click", function() {
        if (item.classList.contains("profile__styles__item")) {

          item.classList.remove("profile__styles__item");
          item.classList.add("account__styles__item");


          var genreName = item.getAttribute("data-genre");
          selectedGenres.push(genreName);
        } else {

          item.classList.remove("account__styles__item");
          item.classList.add("profile__styles__item");

          var genreName = item.getAttribute("data-genre");
          var index = selectedGenres.indexOf(genreName);
          if (index !== -1) {
            selectedGenres.splice(index, 1);
          }
        }

        document.getElementById("selectedGenresField").value = selectedGenres.join(", ");


        console.log("Выбранные жанры: " + selectedGenres.join(", "));
      });
    });
  </script>

  <script>
    const burgerIcon = document.querySelector('.burger-icon');
    const mobileMenu = document.querySelector('.mobile__nav__menu');

    burgerIcon.addEventListener('click', () => {
      mobileMenu.classList.toggle('active');
    });
  </script>

  <script>
    const burgerIconfilters = document.querySelector('.burger__icon__filters');
    const mobileMenufilters = document.querySelector('.mobile__filters__menu');

    burgerIconfilters.addEventListener('click', () => {
      mobileMenufilters.classList.toggle('active');
    });
  </script>

  <script>
    $(document).ready(function() {

      var paginationElement = $('#pagination__reviews');
      var itemsPerPage = 6;
      var totalItems = <?php echo $totalItemsReviews; ?>;
      var totalPages = Math.ceil(totalItems / itemsPerPage);


      $('.account__reviews .reviews__item').hide();


      var visibleItems = $('.account__reviews .reviews__item').slice(0, itemsPerPage);
      visibleItems.show();

      paginationElement.twbsPagination({
        totalPages: totalPages,
        visiblePages: 3,
        initiateStartPageClick: false,

        onPageClick: function(event, page) {
          var startIndex = (page - 1) * itemsPerPage;
          var endIndex = Math.min(startIndex + itemsPerPage, totalItems);

          $('.account__reviews .reviews__item').hide();
          $('.account__reviews .reviews__item').slice(startIndex, endIndex).show();
        },

        onPageFirst: function() {
          paginationElement.twbsPagination('show', 1);
        },

        onPageLast: function() {
          paginationElement.twbsPagination('show', totalPages);
        },

        first: '«',
        last: '»'
      });

    });
  </script>

  <script>
    $(document).ready(function() {

      var paginationElement = $('#pagination__services');
      var itemsPerPage = 5;
      var totalItems = <?php echo $totalItems; ?>;
      var totalPages = Math.ceil(totalItems / itemsPerPage);


      $('.account__services .service__item').hide();


      var visibleItems = $('.account__services .service__item').slice(0, itemsPerPage);
      visibleItems.show();

      paginationElement.twbsPagination({
        totalPages: totalPages,
        visiblePages: 3,
        initiateStartPageClick: false,

        onPageClick: function(event, page) {
          var startIndex = (page - 1) * itemsPerPage;
          var endIndex = Math.min(startIndex + itemsPerPage, totalItems);

          $('.account__services .service__item').hide();
          $('.account__services .service__item').slice(startIndex, endIndex).show();
        },

        onPageFirst: function() {
          paginationElement.twbsPagination('show', 1);
        },

        onPageLast: function() {
          paginationElement.twbsPagination('show', totalPages);
        },

        first: '«',
        last: '»'
      });

    });
  </script>






</body>

</html>