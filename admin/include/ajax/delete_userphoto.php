<?php
session_start();
include('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUserPhoto'])) {
  $PhotoId = $_POST["photo_id"];
  $query = "DELETE FROM portfolio WHERE photo_id = $PhotoId";
  if ($mysqli->query($query) === TRUE) {
    echo "success";
  } else {
    echo "Ошибка при удалении фото:: " . $mysqli->error;
  }
}
?>

