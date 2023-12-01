<?php
include('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $queryReviewCount = "SELECT COUNT(*) AS review_count FROM reviews WHERE user_id = " . $_GET['user_id'];
    $resultReviewCount = $mysqli->query($queryReviewCount);
    $rowReviewCount = $resultReviewCount->fetch_assoc();

if ($rowReviewCount) {
  $reviewCount = $rowReviewCount['review_count'];
  echo $reviewCount;
} else {
  echo 0;
}
}
