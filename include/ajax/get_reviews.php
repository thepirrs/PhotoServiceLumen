<?php
include('../db_connect.php');

$user_id = $_GET['id'];

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
  echo "Пока нет отзывов для этого пользователя.";
}
?>