<?php
include('../db_connect.php');

if (isset($_POST["login"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $getUserQuery = "SELECT user_id, password FROM users WHERE email = ?";
  
  $stmt = $mysqli->prepare($getUserQuery);
  $stmt->bind_param("s", $email);
  $stmt->execute();

  $result = $stmt->get_result();

  if ($result && $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_id = $row["user_id"];
    $hashed_password = $row["password"];

    if (password_verify($password, $hashed_password)) {
      session_start();
      $_SESSION["user_id"] = $user_id;
      $response = "success";
    } else {
      $response = "Неправильный пароль";
    }
  } else {
    $response = "Пользователь с таким email не найден";
  }

  $stmt->close();
  
  echo $response;
  exit();
}
?>