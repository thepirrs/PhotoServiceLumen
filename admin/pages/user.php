<?php include('../include/db_connect.php') ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<?php
if (!isset($_SESSION["admin_id"])) {
  header("Location: /admin/pages/authorization.php");
  exit();
}
?>


<?php
$user_id = $_GET["id"];

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
  <title>Профиль</title>
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/setka.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/portfolio.css">
  <link rel="stylesheet" href="../css/profile.css">
</head>


<body>

  <?php include('../include/menu.php') ?>


  <section class="portfolio">
    <div class="container">

      <div class="profile__btn">
        <div class="row justify__content__between">
          <div class="col-3 portfolio">
            <button class="portfolio__btn" id="showPortfolio">Портфолио</button>
          </div>
          <div class="col-3 price">
            <button class="portfolio__btn" id="showServices">Прайс-лист</button>
          </div>
          <div class="col-3 review">
            <button class="portfolio__btn" id="showReviews">Отзывы</button>
          </div>
          <div class="col-3 review">
            <form method="post">
              <button class="portfolio__btn deleteuser__btn" name="deleteUser">Удалить пользователя</button>
              <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['deleteUser'])) {
                  $user_id = $_GET['id'];

                  $deletePortfolioQuery = "DELETE FROM portfolio WHERE user_id = $user_id";
                  $deletePhotographerGenresQuery = "DELETE FROM photographergenres WHERE user_id = $user_id";
                  $deleteServicesQuery = "DELETE FROM services WHERE user_id = $user_id";
                  $deleteReviewsQuery = "DELETE FROM reviews WHERE review_user_id = $user_id";

                  if (
                    $mysqli->query($deletePortfolioQuery) === TRUE &&
                    $mysqli->query($deletePhotographerGenresQuery) === TRUE &&
                    $mysqli->query($deleteServicesQuery) === TRUE &&
                    $mysqli->query($deleteReviewsQuery) === TRUE
                  ) {

                    $deleteUserQuery = "DELETE FROM users WHERE user_id = $user_id";

                    if ($mysqli->query($deleteUserQuery) === TRUE) {
                      echo '<script>window.location = "/admin/index.php";</script>';
                    } else {
                      echo "Ошибка при удалении пользователя: " . $mysqli->error;
                    }
                  } else {
                    echo "Ошибка при удалении связанных записей: " . $mysqli->error;
                  }
                }
              }
              ?>
            </form>
          </div>
        </div>
      </div>
      <div class="portfolio__reviews" id="reviews">
        <div class="row">
          <div class="col-12">
            <table>
              <tr class="table__title">
                <th>Аватар</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отзыв</th>
                <th>Оценка</th>
                <th>Удалить</th>
              </tr>
              <tbody id="reviewsContainer"></tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="portfolio__block" id="portfolio">
        <div class="row portfoliophoto__block" id="photoContainer">
        </div>
      </div>

      <div class="account__services" id="services">
        <div class="row">
          <div class="col-12">
            <table>
              <tr class="table__title">
                <th>Услуга</th>
                <th>Описание</th>
                <th>Стоимость</th>
                <th>Удалить</th>
              </tr>
              <tbody id="servicesContainer"></tbody>
              <table>
          </div>
        </div>
      </div>

    </div>
  </section>




  <script src="/js/code.jquery.com_jquery-3.7.0.min.js"></script>

  <script>
    $(document).ready(function() {
      var userId = <?php echo $_GET['id']; ?>;

      updatePhotoBlock();

      window.deleteUserPhoto = function(photo_id) {
        $.ajax({
          type: "POST",
          url: "../include/ajax/delete_userphoto.php",
          data: {
            photo_id: photo_id,
            deleteUserPhoto: true
          },
          success: function(response) {
            if (response.trim() === "success") {

              updatePhotoBlock();
            } else {
              console.error(response);
            }
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при удалении услуги: " + error);
          }
        });
      };


      function updatePhotoBlock() {
        $("#photoContainer").load("../include/ajax/get_userphoto.php?id=" + userId);
      }
    });
  </script>

  <script>
    $(document).ready(function() {
      var userId = <?php echo $_GET['id']; ?>;

      updateReviewsBlock();

      window.deleteReview = function(review_id) {
        $.ajax({
          type: "POST",
          url: "../include/ajax/delete_reviews.php",
          data: {
            review_id: review_id,
            deleteReview: true
          },
          success: function(response) {
            if (response.trim() === "success") {

              updateReviewsBlock();
            } else {
              console.error(response);
            }
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при удалении услуги: " + error);
          }
        });
      };


      function updateReviewsBlock() {
        $("#reviewsContainer").load("../include/ajax/get_reviews.php?id=" + userId);
      }
    });
  </script>

  <script>
    $(document).ready(function() {
      var userId = <?php echo $_GET['id']; ?>;

      updateServicesBlock();

      window.deleteServices = function(service_id) {
        $.ajax({
          type: "POST",
          url: "../include/ajax/delete_service.php",
          data: {
            service_id: service_id,
            deleteServices: true
          },
          success: function(response) {
            if (response.trim() === "success") {

              updateServicesBlock();
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
        $("#servicesContainer").load("../include/ajax/get_services.php?id=" + userId);
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
    const burgerIcon = document.querySelector(' .burger-icon');
    const mobileMenu = document.querySelector('.mobile__nav__menu');
    burgerIcon.addEventListener('click', () => {
      mobileMenu.classList.toggle('active');
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
    document.getElementById('openModalBG').addEventListener('click', function() {
      document.getElementById('photoModalBG').style.display = 'flex';
    });

    document.getElementById('closeModalBG').addEventListener('click', function() {
      document.getElementById('photoModalBG').style.display = 'none';
    });

    document.getElementById('uploadButtonBG').addEventListener('click', function() {
      document.getElementById('photoModalBG').style.display = 'none';
    });
  </script>




  <script>
    if ($(document).height() <= $(window).height()) {
      $(".footer").addClass("fixed-bottom");
    }
  </script>


</body>

</html>