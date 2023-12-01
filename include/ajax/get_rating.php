<?php
include('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $queryAverageRating = "SELECT ROUND(IFNULL(AVG(rating), 0), 1) AS avg_rating FROM reviews WHERE user_id = " . $_GET['user_id'];
  $resultAverageRating = $mysqli->query($queryAverageRating);
  $rowAverageRating = $resultAverageRating->fetch_assoc();

  if ($rowAverageRating) {
    $averageRating = $rowAverageRating['avg_rating'];
    echo $averageRating;
  } else {
    echo 0;
  }
}
?>