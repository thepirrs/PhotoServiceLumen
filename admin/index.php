<?php include('include/db_connect.php') ?>

<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<?php
if (!isset($_SESSION["admin_id"])) {
  header("Location: /admin/pages/admin.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Панель управления</title>
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/setka.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>

  <?php include('include/menu.php') ?>

  <section class=" catalog">
    <div class="container">
      <div class="row filters__block">

        <div class="col-12 catalog__list">
          <div class="col-12 catalog__name">
            <h2 class="catalog__title">Каталог фотографов</h2>
          </div>
          <div class="col-12">
            <table>
              <tr class="table__title">
                <th>Аватар</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Город</th>
                <th>Почта</th>
                <th>Номер телефона</th>
                <!--<th>Стоимость</th>
                <th>Отзывы</th>
                <th>Рейтинг</th>-->
              </tr>
              <?php

              $selectedCity = "Выбрать город";
              $searchName = "";

              if (isset($_POST['selectedCity'])) {
                $selectedCity = $mysqli->real_escape_string($_POST['selectedCity']);
              }

              if (isset($_POST['searchName'])) {
                $searchName = $mysqli->real_escape_string($_POST['searchName']);
              }

              $queryUsers = "SELECT user_id, name, surname, city, email, telephone, avatar FROM users WHERE 1=1";

              if ($selectedCity !== "Выбрать город" && $selectedCity !== "all") {
                $queryUsers .= " AND city = '$selectedCity'";
              }

              if (!empty($searchName)) {

                list($name, $surname) = explode(" ", $searchName);
                $name = trim($name);
                $surname = trim($surname);


                if (!empty($name)) {
                  $queryUsers .= " AND name = '$name'";
                }

                if (!empty($surname)) {
                  $queryUsers .= " AND surname = '$surname'";
                }
              }

              $resultUsers = $mysqli->query($queryUsers);

              if ($resultUsers->num_rows > 0) {
                while ($rowUser = $resultUsers->fetch_assoc()) {
                  $user_id = $rowUser['user_id'];
                  $name = $rowUser['name'];
                  $surname = $rowUser['surname'];
                  $city = $rowUser['city'];
                  $email = $rowUser['email'];
                  $telephone = $rowUser['telephone'];
                  $avatar = $rowUser['avatar'];

                  $queryMinPrice = "SELECT IFNULL(MIN(price), 0) AS min_price FROM services WHERE user_id = $user_id";
                  $resultMinPrice = $mysqli->query($queryMinPrice);
                  $rowMinPrice = $resultMinPrice->fetch_assoc();
                  $minPrice = $rowMinPrice['min_price'];

                  $queryReviewCount = "SELECT COUNT(*) AS review_count FROM reviews WHERE user_id = $user_id";
                  $resultReviewCount = $mysqli->query($queryReviewCount);
                  $rowReviewCount = $resultReviewCount->fetch_assoc();
                  $reviewCount = $rowReviewCount['review_count'];

                  $queryAverageRating = "SELECT ROUND(IFNULL(AVG(rating), 0), 1) AS avg_rating FROM reviews WHERE user_id = $user_id";
                  $resultAverageRating = $mysqli->query($queryAverageRating);
                  $rowAverageRating = $resultAverageRating->fetch_assoc();

                  $queryGenres = "SELECT genre_name FROM genres 
    JOIN photographergenres ON genres.genre_id = photographergenres.genre_id 
    WHERE photographergenres.user_id = $user_id";

                  $genres = array();
                  $resultGenres = $mysqli->query($queryGenres);

                  if ($resultGenres->num_rows > 0) {
                    while ($rowGenre = $resultGenres->fetch_assoc()) {
                      $genres[] = $rowGenre['genre_name'];
                    }
                  }
                  $genresString = implode(',', $genres);

                  echo '<tr class="user">';
                  echo '<td><a href="pages/user.php?id=' . $user_id . '">';
                  echo '<img class="avatar__img" src="/' . $avatar . '"></a></td>';
                  echo '<td>' . $name . '</td>';
                  echo '<td>' . $surname . '</td>';
                  echo '<td>' . $city . '</td>';
                  echo '<td><a href="mailto:' . $email . '">' . $email . '</a></td>';
                  echo '<td><a href="tel:' . $telephone . '">' . $telephone . '</a></td>';



                  echo '</tr>';
                }
              }
              ?>
            </table>

          </div>
        </div>

      </div>
    </div>

  </section>





  <script src="/js/code.jquery.com_jquery-3.7.0.min.js"></script>


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
    document.querySelector('.nav__select__city').addEventListener('change', function() {
      document.querySelector('form').submit();
    });
  </script>



  <script>
    if ($(document).height() <= $(window).height()) {
      $(".footer").addClass("fixed-bottom");
    }
  </script>


  <script>

    function initLightbox() {

      const thumbs = document.querySelectorAll('.card__photo-link');

      thumbs.forEach(link => {

        link.addEventListener('click', e => {

          e.preventDefault();

          const imgSrc = link.querySelector('img').getAttribute('src');

          const markup = `
          <div class="lightbox_photo">
            <div class="lightbox__close">&times;</div>
            <img src="${imgSrc}" class="lightbox__image">
          </div>
        `;

          document.body.insertAdjacentHTML('beforeend', markup);

          document.body.style.overflow = 'hidden';

        });

      });

      document.body.addEventListener('click', e => {
        if (e.target.classList.contains('lightbox__close')) {
          closeLightbox();
        }
      });

      document.body.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
          closeLightbox();
        }
      });

    }
 
    function closeLightbox() {
      document.querySelector('.lightbox_photo').remove();
      document.body.style.overflow = '';
    }

    document.addEventListener('DOMContentLoaded', initLightbox);
  </script>

</body>

</html>