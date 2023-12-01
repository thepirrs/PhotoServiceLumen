<?php
include('../db_connect.php');

$user_id = $_GET['id'];
$getPortfolioImagesQuery = "SELECT photo_id, path_to_photo FROM portfolio WHERE user_id = " . $user_id . " ORDER BY photo_id DESC";
$result = $mysqli->query($getPortfolioImagesQuery);

if ($result) {
  while ($row = $result->fetch_assoc()) {
    $photoPath = $row['path_to_photo'];
    echo '<div class="col-3 card__items">';
    echo '<div class="card__photo-container">';
    echo '<form method="post">';
    echo '<input type="hidden" name="photo_id" value="' . $row["photo_id"] . '">';
    echo '<img class="card__photo" src="/' . $photoPath . '">';
    echo '<button type="button" class="delete__button" onclick="deleteUserPhoto(' . $row["photo_id"] . ')">';
    echo '<img class="card__button" src="/img/delete.png">';
    echo '</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
  }
}
?>

