<?php
session_start();
include('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['addreview'])) {
    if (isset($_SESSION["user_id"])) {
      $review_user_id = $_POST['user_id'];
      $reviewer_user_id = $_SESSION["user_id"];
      $rating = intval($_POST["rating"]);
      $review_text = $_POST["review_text"];

      if ($rating <= 0) {
        echo "Пожалуйста, поставьте рейтинг перед отправкой отзыва.";
      } else {
        $query = "INSERT INTO reviews (user_id, review_user_id, rating, review_text) VALUES ('$review_user_id', '$reviewer_user_id', '$rating', '$review_text')";

        if ($mysqli->query($query) === TRUE) {
          echo "success";
        } else {
          echo "Ошибка при добавлении отзыва: " . $mysqli->error;
        }
      }
    } else {
      echo "Пожалуйста, авторизуйтесь на сайте, чтобы оставить отзыв.";
    }
  }
}

?>
