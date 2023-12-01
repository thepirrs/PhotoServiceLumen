<?php
session_start();
include('../db_connect.php');

$user_id = $_GET['id'];
$query = "SELECT service_id, service_name, price, description FROM services WHERE user_id = " . $user_id . " ORDER BY service_id DESC";
$result = $mysqli->query($query);

if ($result) {
  while ($row = $result->fetch_assoc()) {
    echo '<tr class="user">';
    echo '<form method="post">';
    echo '<input type="hidden" name="service_id" value="' . $row["service_id"] . '">';
    echo '<td>' . $row["service_name"] . '</td>';
    echo '<td>' . $row["description"] . ' руб.</td>';
    echo '<td>' . $row["price"] . ' руб.</td>';
    echo '<td>';
    echo '<button type="button" class="delete__button" onclick="deleteServices(' . $row["service_id"] . ')">';
    echo '<img class="cross__img" src="/img/cross.png" alt="Удалить">';
    echo '</button>';
    echo '</td>';
    echo '</form>';
    echo '</tr>';
  }
  $result->free();
} else {
  echo "Ошибка при выполнении запроса: " . $mysqli->error;
}
?>