<?php include('include/db_connect.php') ?>

<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Сервис для поиска фотографов в твоём городе – Lumen</title>
  <meta name="Description"content="Найдите лучших фотографов в вашем городе! Профессионалы с примерами работ. Сравнивайте цены, рейтинги, реальные отзывы.">
  <meta name="keywords" content="фотограф, заказать фотосессию, семейная фотосессия, фотограф недорого, предметная фотосъемка, портфолио фотографа, love story, свадебные фото, фотограф на свадьбу, свадебный фотограф, лучшие фотографы, фотограф цены, найти фотографа, фотосессия девушки, фотосессия">
  <meta property="og:title" content="Сервис для поиска фотографов в твоём городе – Lumen" />
  <meta property="og:description"content="Найдите лучших фотографов в вашем городе! Профессионалы с примерами работ. Сравнивайте цены, рейтинги, реальные отзывы." />
  
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" href="js/owlcarousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="js/owlcarousel/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/setka.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>

  <?php include('include/menu.php') ?>

  <section class="bestcards__carousel">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="bestphoto__title">Лучшие фотографы</h2>
        </div>
      </div>
      <div class="row carousel">
        <div class="col-1 prev_button">
          <img class="carousel__arrows" src="img/arrows.png">
        </div>
        <div class="col-10 cards__list">
          <div class="home-demo">
            <div class="owl-carousel">
              <?php
              $selectedCity = "Выбрать город";

              if (isset($_POST['selectedCity'])) {
                $selectedCity = $mysqli->real_escape_string($_POST['selectedCity']);
              }

              $queryUsers = "SELECT users.user_id, name, surname, avatar, IFNULL(ROUND(AVG(rating), 1), 0) AS avg_rating
              FROM users
              LEFT JOIN reviews ON users.user_id = reviews.user_id
              WHERE photographer = 1";

              if ($selectedCity !== "Выбрать город" && $selectedCity !== "all") {
                $queryUsers .= " AND city = '$selectedCity'";
              }

              $queryUsers .= " GROUP BY users.user_id, name, surname, avatar
              ORDER BY avg_rating DESC";

              $resultUsers = $mysqli->query($queryUsers);

              if ($resultUsers->num_rows > 0) {
                while ($rowUser = $resultUsers->fetch_assoc()) {
                  $user_id = $rowUser['user_id'];
                  $name = $rowUser['name'];
                  $surname = $rowUser['surname'];
                  $avatar = $rowUser['avatar'];

                  echo '<a href="/pages/profile.php?id=' . $user_id . '">';
                  echo '<div class="best__card">';
                  echo '<div class="row photograph__info justify__content__evenly align__items__center">';
                  echo '<div class="col-4 bestcard__avatar"><img class="avatar__carousel" src="' . $avatar . '"></div>';
                  echo '<div class="col-7 card__name">';
                  echo '<p class="fio_style-best">' . $name . '</p>';
                  echo '<p class="fio_style-best">' . $surname . '</p>';
                  echo '</div>';
                  echo '</div>';

                  echo '<div class="row card__marks justify__content__evenly">';

                  $queryAverageRating = "SELECT ROUND(IFNULL(AVG(rating), 0), 1) AS avg_rating FROM reviews WHERE user_id = $user_id";
                  $resultAverageRating = $mysqli->query($queryAverageRating);
                  $rowAverageRating = $resultAverageRating->fetch_assoc();

                  if ($rowAverageRating) {
                    $averageRating = $rowAverageRating['avg_rating'];
                    echo '<div class="best__card__mark">';
                    echo '<div><img class="best__card__icon" src="img/star.png"></div>';
                    echo '<div><p class="best__card__value">' . $averageRating . '</p></div>';
                    echo '</div>';
                  }

                  $queryReviewCount = "SELECT COUNT(*) AS review_count FROM reviews WHERE user_id = $user_id";
                  $resultReviewCount = $mysqli->query($queryReviewCount);
                  $rowReviewCount = $resultReviewCount->fetch_assoc();

                  if ($rowReviewCount) {
                    $reviewCount = $rowReviewCount['review_count'];
                    echo '<div class="best__card__mark">';
                    echo '<div><img class="best__card__icon" src="img/review.png"></div>';
                    echo '<div><p class="best__card__value">' . $reviewCount . '</p></div>';
                    echo '</div>';
                  }

                  $queryMinPrice = "SELECT IFNULL(MIN(price), 0) AS min_price FROM services WHERE user_id = $user_id";
                  $resultMinPrice = $mysqli->query($queryMinPrice);
                  $rowMinPrice = $resultMinPrice->fetch_assoc();

                  if ($rowMinPrice) {
                    $minPrice = $rowMinPrice['min_price'];
                    echo '<div class="best__card__mark">';
                    echo '<div><img class="best__card__icon" src="img/price.png"></div>';
                    echo '<div><p class="best__card__value">' . $minPrice . '</p></div>';
                    echo '</div>';
                  }

                  echo '</div>';

                  echo '</div>';
                  echo '</a>';
                }
              }

              ?>
            </div>
          </div>
        </div>
        <div class="col-1 next_button">
          <img class="carousel__arrows" src="img/arrows2.png"">
        </div>
      </div>
    </div>
  </section>

  <section class=" catalog">
          <div class="container">
            <div class="row filters__block">

                <div class="col-2 filters">
                  <div class="filters__container">
                    <div class="filters__name"><label for="price">Стоимость услуг</label></div>
                    <div class="filters__value"> <input type="number" id="priceMin" class="filter-input" data-filter="minPrice" placeholder="Мин" min="0"></div>
                    <div class="filters__value"> <input type="number" id="priceMax" class="filter-input" data-filter="maxPrice" placeholder="Макс" min="0"></div>
                  </div>

                  <div class="filters__container">
                    <div class="filters__name"><label for="price">Отзывы</label></div>
                    <div class="filters__value"> <input type="number" id="reviewsMin" class="filter-input" data-filter="minReviews" placeholder="Мин" min="0"></div>
                    <div class="filters__value"> <input type="number" id="reviewsMax" class="filter-input" data-filter="maxReviews" placeholder="Макс" min="0"></div>
                  </div>

                  <div>
                    <div class="filters__name"><label>Жанры</label></div>
                    <?php
                    $query = "SELECT genre_name FROM genres";
                    $result = $mysqli->query($query);

                    if ($result) {
                      echo '<div class="filters__checkbox">';

                      while ($row = $result->fetch_assoc()) {
                        $genre = $row['genre_name'];
                        echo '<div class="checkbox__item">';
                        echo '<input type="checkbox" id="' . $genre . '" value="' . $genre . '">';
                        echo '<label for="' . $genre . '">' . $genre . '</label>';
                        echo '</div>';
                      }

                      echo '</div>';

                      $result->close();
                    } else {
                      echo 'Ошибка при выполнении SQL-запроса: ' . $mysqli->error;
                    }
                    ?>
                  </div>

                  <div class="filters__btns">
                    <div class="filters__btn__find">
                      <button class="btn__find apply-filters">Поиск</button>
                    </div>
                    <div class="filters__btn__reset">
                      <button class="btn__reset resetFilters">Сброс</button>
                    </div>
                  </div>
                </div>

                <div class="col-10 catalog__list">
                  <div class="col-12 catalog__name">
                    <h2 class="catalog__title">Каталог фотографов</h2>
                  </div>
                  <div class="row catalog__cards">
                    <?php

                    $selectedCity = "Выбрать город";
                    $searchName = "";

                    if (isset($_POST['selectedCity'])) {
                      $selectedCity = $mysqli->real_escape_string($_POST['selectedCity']);
                    }

                    if (isset($_POST['searchName'])) {
                      $searchName = $mysqli->real_escape_string($_POST['searchName']);
                    }

                    $queryUsers = "SELECT user_id, name, surname, avatar FROM users WHERE photographer = 1";

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

                        echo '<div class="col-3-5" data-min-price="' . $minPrice . '" data-review-count="' . $reviewCount . '" data-genres="' . $genresString . '">';
                        echo '<div class="card">';
                        echo '<a href="/pages/profile.php?id=' . $user_id . '"><div class="row cardphotograph__info">';
                        echo '<div class="col-3 card__avatar"><img class="avatar__card" src="' . $avatar . '"></div>';
                        echo '<div class="col-7 cardd__name">';
                        echo '<p class="fio_style">' . $name . '</p>';
                        echo '<p class="fio_style">' . $surname . '</p>';
                        echo '</div></div></a>';

                        echo '<div class="row card__marksss">';


                        if ($rowAverageRating) {
                          $averageRating = $rowAverageRating['avg_rating'];

                          echo '<div class="col-4-card">';
                          echo '<div><p class="marks__value">' . $averageRating . '</p></div>';
                          echo '<div><p>Рейтинг</p></div>';
                          echo '</div>';
                        }

                        if ($rowReviewCount) {
                          $reviewCount = $rowReviewCount['review_count'];

                          echo '<div class="col-4-card">';
                          echo '<div><p class="marks__value">' . $reviewCount . '</p></div>';
                          echo '<div><p>Отзывы</p></div>';
                          echo '</div>';
                        }

                        if ($rowMinPrice) {
                          $minPrice = $rowMinPrice['min_price'];
                          echo '<div class="col-4-card">';
                          echo '<div><p class="marks__value">' . $minPrice . ' Р</p></div>';
                          echo '<div><p>Стоимость</p></div>';
                          echo '</div>';
                        }

                        echo '</div>';


                        $queryPhotos = "SELECT path_to_photo FROM portfolio WHERE user_id = $user_id ORDER BY photo_id DESC LIMIT 3";
                        $resultPhotos = $mysqli->query($queryPhotos);

                        if ($resultPhotos->num_rows > 0) {
                          echo '<div class="row card__marksss">';

                          while ($rowPhoto = $resultPhotos->fetch_assoc()) {
                            $photoPath = $rowPhoto['path_to_photo'];
                            echo '<div class="col-4-card"><a href="' . $photoPath . '" class="card__photo-link">';
                            echo '<img class="card__photo" src="' . $photoPath . '"></a></div>';
                          }

                          echo '</div>';
                        }

                        echo '</div></div>';
                      }
                    }
                    ?>
                    <div class="col-3-5"></div>
                    <div class="col-12 pagination" id="pagination"></div>
                    <?php
                    $query = "SELECT COUNT(*) as totalItems FROM users WHERE photographer = 1";

                    $result = $mysqli->query($query);

                    if ($result) {
                      $row = $result->fetch_assoc();
                      $totalItems = $row['totalItems'];
                    } else {
                      die("Ошибка при выполнении запроса: " . $mysqli->error);
                    }
                    ?>
                  </div>
                </div>

              </div>
            </div>

  </section>

  <?php include('include/footer.php') ?>



  <script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
  <script src="js/owlcarousel/owl.carousel.min.js"></script>
  <script src="js/jquery-pagination.js"></script>
  



  <script>
    $(function() {
      var owl = $(".owl-carousel");
      owl.owlCarousel({
        items: 4,
        margin: 30,
        loop: true,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1
          },
          530: {
            items: 2
          },
          1050: {
            items: 3
          },
          1440: {
            items: 4
          }
        }
      });
      $(".next_button").click(function() {
        owl.trigger("next.owl.carousel");
      });

      $(".prev_button").click(function() {
        owl.trigger("prev.owl.carousel");
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
    document.querySelector('.nav__select__city').addEventListener('change', function() {
      document.querySelector('form').submit();
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelector(".apply-filters").addEventListener("click", function() {
        var priceMinInput = document.querySelector(".filter-input[data-filter='minPrice']");
        var priceMaxInput = document.querySelector(".filter-input[data-filter='maxPrice']");
        var priceMin = priceMinInput.value ? parseFloat(priceMinInput.value) : Number.NEGATIVE_INFINITY;
        var priceMax = priceMaxInput.value ? parseFloat(priceMaxInput.value) : Number.POSITIVE_INFINITY;

        var reviewsMinInput = document.querySelector(".filter-input[data-filter='minReviews']");
        var reviewsMaxInput = document.querySelector(".filter-input[data-filter='maxReviews']");
        var reviewsMin = reviewsMinInput.value ? parseFloat(reviewsMinInput.value) : Number.NEGATIVE_INFINITY;
        var reviewsMax = reviewsMaxInput.value ? parseFloat(reviewsMaxInput.value) : Number.POSITIVE_INFINITY;

        var selectedGenres = [];
        var genreCheckboxes = document.querySelectorAll(".filters__checkbox input[type='checkbox']");
        genreCheckboxes.forEach(function(checkbox) {
          if (checkbox.checked) {
            selectedGenres.push(checkbox.value);
          }
        });

        var cards = document.querySelectorAll(".col-3-5");

        cards.forEach(function(card) {
          var minPrice = parseFloat(card.getAttribute("data-min-price"));
          var reviewCount = parseFloat(card.getAttribute("data-review-count"));
          var cardGenres = card.getAttribute("data-genres").split(',');

          var priceFilterPassed = minPrice >= priceMin && minPrice <= priceMax;
          var reviewsFilterPassed = reviewCount >= reviewsMin && reviewCount <= reviewsMax;
          var genresFilterPassed = selectedGenres.length === 0 || selectedGenres.every(function(selectedGenre) {
            return cardGenres.includes(selectedGenre);
          });

          if (priceFilterPassed && reviewsFilterPassed && genresFilterPassed) {
            card.style.display = "block"; 
          } else {
            card.style.display = "none"; 
          }
        });
      });

      document.querySelector(".resetFilters").addEventListener("click", function() {
        var filterInputs = document.querySelectorAll(".filter-input");
        filterInputs.forEach(function(input) {
          input.value = ""; 
        });

        var genreCheckboxes = document.querySelectorAll(".filters__checkbox input[type='checkbox']");
        genreCheckboxes.forEach(function(checkbox) {
          checkbox.checked = false; 
        });

        var cards = document.querySelectorAll(".col-3-5");
        cards.forEach(function(card) {
          card.style.display = "block";
        });
      });

    });
  </script>

  <script>
    $(document).ready(function() {

      var paginationElement = $('#pagination');
      var itemsPerPage = 12;
      var totalItems = <?php echo $totalItems; ?>;
      var totalPages = Math.ceil(totalItems / itemsPerPage);


      $('.catalog__cards .col-3-5').hide();


      var visibleItems = $('.catalog__cards .col-3-5').slice(0, itemsPerPage);
      visibleItems.show();

      paginationElement.twbsPagination({
        totalPages: totalPages,
        visiblePages: 3,
        initiateStartPageClick: false,

        onPageClick: function(event, page) {
          var startIndex = (page - 1) * itemsPerPage;
          var endIndex = Math.min(startIndex + itemsPerPage, totalItems);

          $('.catalog__cards .col-3-5').hide();
          $('.catalog__cards .col-3-5').slice(startIndex, endIndex).show();
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