<?php
include('../db_connect.php');

if (isset($_POST["register"])) {
  $name = $_POST["name"];
  $surname = $_POST["surname"];
  $city = $_POST["city"];
  $email = $_POST["email"];
  $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

  $checkEmailQuery = "SELECT user_id FROM users WHERE email = ?";
  $stmt = $mysqli->prepare($checkEmailQuery);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows > 0) {
    echo "Пользователь с таким email уже существует";
  } else {
    $insertQuery = "INSERT INTO users (name, surname, city, email, password, photographer) VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = $mysqli->prepare($insertQuery);
    $stmt->bind_param("sssss", $name, $surname, $city, $email, $password);

    if ($stmt->execute()) {
      $response = "Регистрация успешно завершена";
    } else {
      $response = "Ошибка регистрации";
    }
  }

  $stmt->close();

  echo $response;
}
?>