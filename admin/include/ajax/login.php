<?php
include('../db_connect.php');

if (isset($_POST["login"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $getUserQuery = "SELECT admin_id, password FROM admin WHERE email = ?";
  $stmt = $mysqli->prepare($getUserQuery);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $admin_id = $row["admin_id"];
    $hashed_password = $row["password"];

    if (password_verify($password, $hashed_password)) {
      session_start();
      $_SESSION["admin_id"] = $admin_id;
      $response = "success";
    } else {
      $response = "Неправильный пароль";
    }
  } else {
    $response = "Пользователь с таким email не найден";
  }
  echo $response;
  exit();
}
