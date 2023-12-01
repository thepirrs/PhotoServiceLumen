<?php
session_start();
include('../db_connect.php');

$query = "SELECT service_id, service_name, price, description FROM services WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY service_id DESC";
$result = $mysqli->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-12 service__item">';
        echo '<div class="service__title">';
        echo '<div class="service__name">' . $row["service_name"] . '</div>';
        echo '<div class="service__price">' . $row["price"] . ' руб.</div>';
        echo '<div class="service__delete">';
        echo '<button type="button" class="delete__button" onclick="deleteService(' . $row["service_id"] . ')">';
        echo '<img class="cross__img" src="/img/cross.png" alt="Удалить">';
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '<div class="service__text">' . $row["description"] . '</div>';
        echo '</div>';
    }
    $result->free();
} else {
    echo "Ошибка при выполнении запроса: " . $mysqli->error;
}
?>
