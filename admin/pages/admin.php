<?php include('../include/db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Авторизация</title>
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/setka.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/authorization.css">
</head>

<body>
  <div class="container">
    <div class="row allforms">
      <div class="col-4 modal-content">

        <div class="register__logo">
          <img class="logo__img" src="../img/logo.png" alt="">
        </div>

        <form id="loginForm" class="modal-form" method="post">
          <div class="register__form">
            <input type="text" id="email" name="email" placeholder="Email" required>
          </div>

          <div class="register__form">
            <input type="password" id="password" name="password" placeholder="Пароль" required>
          </div>

          <button class="reg__enterBtn" type="submit" name="login">Войти</button>

          <div id="loginMessage" class="message">
          </div>
        </form>

      </div>
    </div>
  </div>

  <script src="/js/code.jquery.com_jquery-3.7.0.min.js"></script>
  <script>
    $(document).ready(function() {

      function loginUser(userData) {
        $.ajax({
          type: "POST",
          url: "../include/ajax/login.php",
          data: userData,
          success: function(response) {
            if (response === "success") {
              window.location.href = "/admin/index.php";
            } else {

              $("#loginMessage").html(response);
            }
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при авторизации: " + error);
          }
        });
      }


      $("#loginForm").submit(function(event) {
        event.preventDefault();

        var loginEmail = $("#email").val();
        var loginPassword = $("#password").val();

        var userData = {
          email: loginEmail,
          password: loginPassword,
          login: true
        };

        loginUser(userData);
      });
    });
  </script>


</body>

</html>