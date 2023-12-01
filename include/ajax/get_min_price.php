<?php
session_start();
include('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $queryMinPrice = "SELECT IFNULL(MIN(price), 0) AS min_price FROM services WHERE user_id = " . $_SESSION["user_id"];
    $resultMinPrice = $mysqli->query($queryMinPrice);
    $rowMinPrice = $resultMinPrice->fetch_assoc();

    if ($rowMinPrice) {
        $minPrice = $rowMinPrice['min_price'];
        echo $minPrice;
    } else {
        echo 0;
    }
}
?>