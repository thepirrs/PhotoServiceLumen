<?php
session_start();
include('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteServices'])) {
    $serviceId = $_POST["service_id"];
    $query = "DELETE FROM services WHERE service_id = $serviceId";
    if ($mysqli->query($query) === TRUE) {
      echo "success";
    } else {
      echo "Ошибка при удалении услуги: " . $mysqli->error;
    }

}
?>

