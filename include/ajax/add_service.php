<?php
session_start();
include('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['saveservice'])) {
    $user_id = $_SESSION["user_id"];
    $serviceName = $_POST["serviceName"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    $query = "INSERT INTO services (user_id, service_name, price, description) VALUES ('$user_id', '$serviceName', '$price', '$description')";

    if ($mysqli->query($query) === TRUE) {
      echo "success";
    } else {
      echo "Ошибка при добавлении услуги: " . $mysqli->error;
    }
  }
}
?>
