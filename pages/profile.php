<?php include('../include/db_connect.php') ?>

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
  <title>Профиль</title>
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/setka.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/profile.css">
</head>

<body>

  <?php include('../include/menu.php') ?>

  <section class="profile">
    <?php
    $user_id = $_GET['id'];
    $queryUser = "SELECT name, surname, city, avatar, background, email, telephone, socinst, socvk, soctg, description FROM users WHERE user_id = $user_id";
    $resultUser = $mysqli->query($queryUser);

    if ($resultUser->num_rows > 0) {
      $rowUser = $resultUser->fetch_assoc();
      $name = $rowUser['name'];
      $surname = $rowUser['surname'];
      $city = $rowUser['city'];
      $avatar = $rowUser['avatar'];
      $background = $rowUser['background'];
      $telephone = $rowUser['telephone'];
      $email = $rowUser['email'];
      $socinst = $rowUser['socinst'];
      $socvk = $rowUser['socvk'];
      $soctg = $rowUser['soctg'];
      $description = $rowUser['description'];
    }
    ?>
    <div class="profile__fon">
      <?php
      if (!empty($background)) {
        echo '<img class="fon__image " src="/' . $background . '" alt="User Fon">';
      } else {
        echo '<img class="fon__image " src="/img/fon.jpg" alt="User Fon">';
      }
      ?>
    </div>

    <div class="container">
      <div class="row allblocks">
        <div class="col-4 profile__block">



          <div class="row profile__info justify__content__evenly align__items__center">
            <div class="col-3 profile__avatar"><img class="profile__avatar__img" src="/<?php echo $avatar; ?>"></div>
            <div class="col-7 profile__name">
              <p class="name__style"><?php echo $name; ?></p>
              <p class="name__style"><?php echo $surname; ?></p>
              <p><?php echo $city; ?></p>
            </div>
          </div>

          <hr class="profile__line">


          <div class="row profile__marks">

            <div class="col-4-card">
              <div>
                <p class="marks__value"><span class="rating_value">0</span></p>
              </div>
              <div>
                <p>Рейтинг</p>
              </div>
            </div>

            <div class="col-4-card">
              <div>
                <p class="marks__value"><span class="count__reviews_value">0</span></p>
              </div>
              <div>
                <p>Отзывы</p>
              </div>
            </div>
            <?php
            $queryMinPrice = "SELECT IFNULL(MIN(price), 0) AS min_price FROM services WHERE user_id = $user_id";
            $resultMinPrice = $mysqli->query($queryMinPrice);
            $rowMinPrice = $resultMinPrice->fetch_assoc();

            if ($rowMinPrice) {
              $minPrice = $rowMinPrice['min_price'];
              echo '<div class="col-4-card">';
              echo '<div><p class="marks__value">' . $minPrice . ' Р</p></div>';
              echo '<div><p>Стоимость</p></div>';
              echo '</div>';
            }
            ?>
          </div>

          <div class="profile__styles">
            <div class="profile__styles__name">Жанры:</div>
            <?php
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
            ?>
            <div class="profile__styles__items">
              <?php
              foreach ($genres as $genre) {
                echo '<div class="profile__styles__item">' . $genre . '</div>';
              }
              ?>
            </div>
          </div>

          <div class="profile__about">
            <div class="profile__about__name">О себе:</div>
            <div class="profile__about__text"><?php echo $description; ?></div>
          </div>

          <hr class="profile__line">

          <div class="profile__contacts">
            <div class="profile__contacts__name">Контакты:</div>
            <div>
              <div class="profile__contacts__phone">
                <img class="phone__icon" src="/img/phone.png" alt="">
                <p class="phone__number"><?php echo $telephone; ?></p>
              </div>
            </div>
            <div>
              <div class="profile__contacts__email">
                <img class="email__icon" src="/img/email.png" alt="">
                <p class="email__text"><?php echo $email; ?></p>
              </div>
            </div>
            <div class="profile__contacts__soc">
              <a href="https://instagram.com/<?php echo $socinst; ?>"><img class="profile__contacts__soc__item" src="/img/inst.png" alt=""></a>
              <a href="http://vk.com/id<?php echo $socvk; ?>"><img class="profile__contacts__soc__item" src="/img/vk.png" alt=""></a>
              <a href="https://t.me/<?php echo $soctg; ?>"><img class="profile__contacts__soc__item" src="/img/tg.png" alt=""></a>
            </div>
          </div>

        </div>

        <div class="col-8 profile__portfolio">
          <div class="row profile__btn">
            <div class="col-4 portfolio">
              <button class="portfolio__btn" id="showPortfolio">Портфолио</button>
            </div>
            <div class="col-4 price">
              <button class="portfolio__btn" id="showServices">Прайс-лист</button>
            </div>
            <div class="col-4 review">
              <button class="portfolio__btn" id="showReviews">Отзывы</button>
            </div>
          </div>

          <div class="row portfolio__photo" id="portfolio">
            <?php
            $queryPhotos = "SELECT path_to_photo FROM portfolio WHERE user_id = $user_id ORDER BY photo_id DESC";
            $resultPhotos = $mysqli->query($queryPhotos);

            if ($resultPhotos->num_rows > 0) {

              while ($rowPhoto = $resultPhotos->fetch_assoc()) {
                $photoPath = $rowPhoto['path_to_photo'];
                echo '<div class="col-4 photo__block"><a href="' . $photoPath . '" class="card__photo-link">';
                echo '<div><img class="photo__item" src="/' . $photoPath . '"></a></div>';
                echo '</div>';
              }
            }
            ?>
            <div class="col-12 pagination" id="pagination_portfolio"></div>
            <?php
            $query = "SELECT COUNT(*) as totalItems FROM portfolio WHERE user_id = $user_id";

            $result = $mysqli->query($query);

            if ($result) {
              $row = $result->fetch_assoc();
              $totalItems = $row['totalItems'];
            } else {
              die("Ошибка при выполнении запроса: " . $mysqli->error);
            }
            ?>
          </div>

          <div class="row portfolio__price" id="services">
            <?php
            $query = "SELECT service_id, service_name, price, description FROM services WHERE user_id = $user_id ORDER BY service_id DESC";
            $result = $mysqli->query($query);

            if ($result) {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="col-12 service__item">';
                echo '<div class="service__title">';
                echo '<div class="service__name">' . $row["service_name"] . '</div>';
                echo '<div class="service__price">' . $row["price"] . ' руб.</div>';
                echo '</div>';
                echo '<div class="service__text">' . $row["description"] . '</div>';
                echo '</div>';
              }
              $result->free();
            } else {
              echo "Ошибка при выполнении запроса: " . $mysqli->error;
            }
            ?>
            <div class="col-12 pagination" id="pagination_service"></div>
            <?php
            $query = "SELECT COUNT(*) as totalItemsServices FROM services WHERE user_id = $user_id";

            $result = $mysqli->query($query);

            if ($result) {
              $row = $result->fetch_assoc();
              $totalItemsServices = $row['totalItemsServices'];
            } else {
              die("Ошибка при выполнении запроса: " . $mysqli->error);
            }
            ?>
          </div>

          <div class="row portfolio__reviews" id="reviews">
            <?php
            if (isset($_SESSION["user_id"])) {

              $userrews_id = $_SESSION["user_id"];
              $queryUserRews = "SELECT name, surname, avatar FROM users WHERE user_id = $userrews_id";
              $resultUserRews = $mysqli->query($queryUserRews);

              if ($resultUserRews && $resultUserRews->num_rows > 0) {
                $userInfo = $resultUserRews->fetch_assoc();
                $userName = $userInfo["name"];
                $userSurname = $userInfo["surname"];
                $userAvatar = $userInfo["avatar"];
              }
            }
            ?>

            <?php if (isset($_SESSION["user_id"])) : ?>
              <div class="col-12 reviews__client">
                <div class="reviews__title">

                  <div class="reviews__name">
                    <div class="reviews__avatar"><img class="client__avatar" src="/<?php echo $userAvatar; ?>" alt=""></div>
                    <div class="client__name">
                      <p class="client__style"><?php echo $userName; ?></p>
                      <p class="client__style"><?php echo $userSurname; ?></p>
                    </div>
                  </div>

                  <div class="reviews__grade">
                    <div class="client__grade"><img class="grade__stars" src="/img/star0.png" alt="" data-rating="1"></div>
                    <div class="client__grade"><img class="grade__stars" src="/img/star0.png" alt="" data-rating="2"></div>
                    <div class="client__grade"><img class="grade__stars" src="/img/star0.png" alt="" data-rating="3"></div>
                    <div class="client__grade"><img class="grade__stars" src="/img/star0.png" alt="" data-rating="4"></div>
                    <div class="client__grade"><img class="grade__stars" src="/img/star0.png" alt="" data-rating="5"></div>
                  </div>
                </div>
                <form id="addReviewForm">
                  <div class="reviews__text">
                    <textarea name="review_text" class="сlient__text" placeholder="Напишите ваш отзыв о работе с фотографом..."></textarea>
                    <input type="hidden" name="rating" id="rating" value="0">
                  </div>
                  <div class="revies__button">
                    <button type="button" id="addReviewButton" class="revies__btn">Оставить отзыв</button>
                  </div>
                </form>
              </div>
            <?php endif; ?>

            <div id="getReviews" class="reviewsBlock"></div>


            <?php
            $user_id = $_GET['id'];
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

  </section>





  <?php include('../include/footer.php') ?>




  <script src="/js/code.jquery.com_jquery-3.7.0.min.js"></script>
  <script src="/js/jquery-pagination.js"></script>

  <script>
    $(document).ready(function() {
      var userId = <?php echo $_GET['id']; ?>;
      updateReviewsBlock(userId);
      updateCountReviewsBlock();
      updateRatingBlock();


      $("#addReviewButton").click(function() {
        $.ajax({
          type: "POST",
          url: "/include/ajax/add_review.php",
          data: $("#addReviewForm").serialize() + "&user_id=" + userId + "&addreview=1",
          success: function(response) {
            if (response === "success") {
              $("#addReviewForm")[0].reset();
              updateReviewsBlock();
              updateCountReviewsBlock();
              updateRatingBlock();
            } else {
              console.error(response);
            }
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при добавлении услуги: " + error);
          }
        });
      });


      function updateReviewsBlock() {
        $("#getReviews").load("/include/ajax/get_reviews.php?id=" + userId);
      }

      function updateCountReviewsBlock() {
        $.ajax({
          type: "GET",
          url: "/include/ajax/get_reviewscount.php?user_id=" + userId,
          success: function(reviewCount) {
            $(".count__reviews_value").text(reviewCount);
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при получении количества отзывов: " + error);
          }
        });
      }

      function updateRatingBlock() {
        $.ajax({
          type: "GET",
          url: "/include/ajax/get_rating.php?user_id=" + userId,
          success: function(averageRating) {
            $(".rating_value").text(averageRating);
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при получении количества отзывов: " + error);
          }
        });
      }
    });
  </script>


  <script>
    $(document).ready(function() {

      $("#reviews").hide();
      $("#services").hide();
      $("#portfolio").show();


      $("#showPortfolio").click(function() {
        $("#reviews").hide();
        $("#services").hide();
        $("#portfolio").show();
        return false;
      });

      $("#showServices").click(function() {
        $("#portfolio").hide();
        $("#reviews").hide();
        $("#services").show();
        return false;
      });

      $("#showReviews").click(function() {
        $("#portfolio").hide();
        $("#services").hide();
        $("#reviews").show();
        return false;
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
    const stars = document.querySelectorAll(".grade__stars");
    let rating = 0;

    stars.forEach((star, index) => {
      star.addEventListener("mouseover", () => {
        highlightStars(index);
      });

      star.addEventListener("click", () => {
        rating = index + 1;
        highlightStars(index);
        document.getElementById("rating").value = rating;
      });
    });

    function highlightStars(index) {
      stars.forEach((star, i) => {
        if (i <= index) {
          star.classList.add("active");
        } else {
          star.classList.remove("active");
        }
      });
    }
  </script>

  <script>
    $(document).ready(function() {

      var paginationElement = $('#pagination_portfolio');
      var itemsPerPage = 9;
      var totalItems = <?php echo $totalItems; ?>;
      var totalPages = Math.ceil(totalItems / itemsPerPage);


      $('.portfolio__photo .photo__block').hide();


      var visibleItems = $('.portfolio__photo .photo__block').slice(0, itemsPerPage);
      visibleItems.show();

      paginationElement.twbsPagination({
        totalPages: totalPages,
        visiblePages: 3,
        initiateStartPageClick: false,

        onPageClick: function(event, page) {
          var startIndex = (page - 1) * itemsPerPage;
          var endIndex = Math.min(startIndex + itemsPerPage, totalItems);

          $('.portfolio__photo .photo__block').hide();
          $('.portfolio__photo .photo__block').slice(startIndex, endIndex).show();
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

      var paginationElement = $('#pagination_service');
      var itemsPerPage = 8;
      var totalItems = <?php echo $totalItemsServices; ?>;
      var totalPages = Math.ceil(totalItems / itemsPerPage);


      $('.portfolio__price .service__item').hide();


      var visibleItems = $('.portfolio__price .service__item').slice(0, itemsPerPage);
      visibleItems.show();

      paginationElement.twbsPagination({
        totalPages: totalPages,
        visiblePages: 3,
        initiateStartPageClick: false,

        onPageClick: function(event, page) {
          var startIndex = (page - 1) * itemsPerPage;
          var endIndex = Math.min(startIndex + itemsPerPage, totalItems);

          $('.portfolio__price .service__item').hide();
          $('.portfolio__price .service__item').slice(startIndex, endIndex).show();
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

      var paginationElement = $('#pagination__reviews');
      var itemsPerPage = 8;
      var totalItems = <?php echo $totalItemsReviews; ?>;
      var totalPages = Math.ceil(totalItems / itemsPerPage);


      $('.portfolio__reviews .reviews__item').hide();


      var visibleItems = $('.portfolio__reviews .reviews__item').slice(0, itemsPerPage);
      visibleItems.show();

      paginationElement.twbsPagination({
        totalPages: totalPages,
        visiblePages: 3,
        initiateStartPageClick: false,

        onPageClick: function(event, page) {
          var startIndex = (page - 1) * itemsPerPage;
          var endIndex = Math.min(startIndex + itemsPerPage, totalItems);

          $('.portfolio__reviews .reviews__item').hide();
          $('.portfolio__reviews .reviews__item').slice(startIndex, endIndex).show();
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

  <script>
    if ($(document).height() <= $(window).height()) {
      $(".footer").addClass("fixed-bottom");
    }
  </script>


</body>

</html>