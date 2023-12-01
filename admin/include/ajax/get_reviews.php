<?php
include('../db_connect.php');

$user_id = $_GET['id'];

$queryReviews = "SELECT r.review_id, r.rating, r.review_text, u.name, u.surname, u.avatar
      FROM reviews r
      JOIN users u ON r.review_user_id = u.user_id
      WHERE r.user_id = $user_id
      ORDER BY r.review_id DESC";

$resultReviews = $mysqli->query($queryReviews);

if ($resultReviews && $resultReviews->num_rows > 0) {
  while ($row = $resultReviews->fetch_assoc()) {
    $review_id = $row["review_id"];
    $rating = $row["rating"];
    $review_text = $row["review_text"];
    $reviewer_name = $row["name"];
    $reviewer_surname = $row["surname"];
    $reviewer_avatar = $row["avatar"];
?>

      <tr class="user">
        <form method="post">
          <input type="hidden" name="review_id" value="<?php echo $review_id; ?>">
          <td><img class="avatar__img" src="/<?php echo $reviewer_avatar; ?>" alt="Аватар пользователя"></td>
          <td><?php echo $reviewer_name; ?></td>
          <td><?php echo $reviewer_surname; ?></td>
          <td><?php echo $review_text; ?></td>
          <td><?php echo $rating; ?></td>
          <td><button type="button" class="delete__button" onclick="deleteReview(<?php echo $review_id; ?>)"><img class="cross__img" src="/img/cross.png" alt="Удалить"></button></td>
        </form>
      </tr>


<?php
  }
} else {
  echo "У пользователя нет отзывов";
}
?>