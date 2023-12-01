<?php
session_start();
include('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteReview'])) {
  $review_id = $_POST["review_id"];

  $query = "DELETE FROM reviews WHERE review_id = $review_id";
  if ($mysqli->query($query) === TRUE) {
    echo "success";
  } else {
    echo "Ошибка при удалении услуги: " . $mysqli->error;
  }
}
?>