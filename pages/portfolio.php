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
  <title>Мое портфолио</title>
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/setka.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/portfolio.css">
</head>


<body>

  <?php include('../include/menu.php') ?>


  <section class="portfolio">
    <div class="portfolio__fon">
      <?php
      $user_id = $_SESSION["user_id"];
      $getImageQuery = "SELECT background FROM users WHERE user_id = $user_id";
      $result = $mysqli->query($getImageQuery);

      if ($result) {
        $row = $result->fetch_assoc();
        $avatarPath = $row['background'];

        if (!empty($avatarPath)) {
          echo '<img class="fon__image " src="/' . $avatarPath . '" alt="User Fon">';
        } else {
          echo '<img class="fon__image " src="/img/fon.jpg" alt="User Fon">';
        }
      }
      ?>
      <button class="fon_btn" id="openModalBG">
        <img class="editfon__btn" src="/img/editfon.png">
      </button>
      <div class="modal" id="photoModalBG">
        <div class="modal-content">
          <span class="close" id="closeModalBG">&#10006;</span>
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

            $updateImageQuery = "UPDATE users SET background = ? WHERE user_id = ?";
            $stmt = $mysqli->prepare($updateImageQuery);
            $stmt->bind_param("si", $targetFile, $user_id);

            if ($stmt->execute()) {
              echo '<script>window.location = "portfolio.php";</script>';
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

    </div>

    <div class="container">
      <div class="portfolio__block">
        <div class="portfilio__btnadd">
          <button class="addphoto__btn" id="openModal">Добавить фото</button>
          <div class="modal" id="photoModal">
            <div class="modal-content">
              <span class="close" id="closeModal">&#10006;</span>
              <form method="post" enctype="multipart/form-data">
                <input type="submit" value="Загрузить" class="addphoto__btn">
                <label for="portfolio_image" class="custom-file-upload">
                  <input type="file" name="portfolio_image" id="portfolio_image" accept="image/*">
                </label>
              </form>
            </div>
          </div>

        </div>
        <div class="row portfoliophoto__block">
          <?php
          $user_id = $_SESSION["user_id"];
          $getPortfolioImagesQuery = "SELECT photo_id, path_to_photo FROM portfolio WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY photo_id DESC";
          $result = $mysqli->query($getPortfolioImagesQuery);

          if ($result) {
            while ($row = $result->fetch_assoc()) {
              $photoPath = $row['path_to_photo'];
              echo '<div class="col-3 card__items">';
              echo '<div class="card__photo-container">';
              echo '<form method="post">';
              echo '<input type="hidden" name="photo_id" value="' . $row["photo_id"] . '">';
              echo '<img class="card__photo" src="/' . $photoPath . '">';
              echo '<button type="submit" name="deletephoto" class="delete__button">';
              echo '<img class="card__button" src="/img/delete.png">';
              echo '</button>';
              echo '</form>';
              echo '</div>';
              echo '</div>';
            }
          }
          ?>
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["portfolio_image"])) {
            $user_id = $_SESSION["user_id"];

            $uploadDirectory = "../uploads/";
            $targetFile = $uploadDirectory . basename($_FILES["portfolio_image"]["name"]);


            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");

            if (in_array($imageFileType, $allowedExtensions)) {

              if (move_uploaded_file($_FILES["portfolio_image"]["tmp_name"], $targetFile)) {

                $insertImageQuery = "INSERT INTO portfolio (user_id, path_to_photo) VALUES (?, ?)";
                $stmt = $mysqli->prepare($insertImageQuery);
                $stmt->bind_param("is", $user_id, $targetFile);

                if ($stmt->execute()) {
                  echo '<script>window.location = "portfolio.php";</script>';
                } else {
                  echo "Ошибка при добавлении фотографии в портфолио.";
                }
              } else {
                echo "Ошибка при загрузке файла.";
              }
            } else {
              echo "Допустимы только изображения с расширениями: jpg, jpeg, png, gif.";
            }
          }
          ?>

          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['deletephoto'])) {
              $PhotoId = $_POST["photo_id"];

              $query = "DELETE FROM portfolio WHERE photo_id = $PhotoId";
              if ($mysqli->query($query) === TRUE) {
                echo '<script>window.location = "portfolio.php";</script>';
              } else {
                echo "Ошибка при удалении фото: " . $mysqli->error;
              }
            }
          }
          ?>

          <div class="col-12 pagination" id="pagination"></div>
          <?php
          $user_id = $_SESSION["user_id"];

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
      </div>
    </div>


  </section>





  <?php include('../include/footer.php') ?>




  <script src="/js/code.jquery.com_jquery-3.7.0.min.js"></script>
  <script src="/js/jquery-pagination.js"></script>

  <script>
    $(document).ready(function() {

      var paginationElement = $('#pagination');
      var itemsPerPage = 8;
      var totalItems = <?php echo $totalItems; ?>;
      var totalPages = Math.ceil(totalItems / itemsPerPage);


      $('.portfoliophoto__block .card__items').hide();


      var visibleItems = $('.portfoliophoto__block .card__items').slice(0, itemsPerPage);
      visibleItems.show();

      paginationElement.twbsPagination({
        totalPages: totalPages,
        visiblePages: 3,
        initiateStartPageClick: false,

        onPageClick: function(event, page) {
          var startIndex = (page - 1) * itemsPerPage;
          var endIndex = Math.min(startIndex + itemsPerPage, totalItems);

          $('.portfoliophoto__block .card__items').hide();
          $('.portfoliophoto__block .card__items').slice(startIndex, endIndex).show();
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
    const burgerIcon = document.querySelector('.burger-icon');
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