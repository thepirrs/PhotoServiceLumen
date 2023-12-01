<?php include('../include/db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="icon" href="/img/favicon.ico">
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/setka.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/authorization.css">
</head>

<body>
  <div class="container">
    <div class="row allforms">
      <div class="col-4 modal-content">

        <div class="register__logo">
          <img class="logo__img" src="/img/logo.png" alt="">
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

          <div class="register">
            <p class="register__text">У вас нет аккаунта?</p>
            <p class="register__text" id="showRegistrationForm">Зарегистрироваться</p>
          </div>
        </form>

        <form id="registrationForm" class="modal-form" method="post">

          <div class="register__name">
            <p class="register__text">Регистрация</p>
          </div>

          <div class="register__form">
            <input type="text" id="name" name="name" placeholder="Имя" required>
          </div>

          <div class="register__form"> <input type="text" id="surname" name="surname" placeholder="Фамилия" required>
          </div>

          <div class="register__form">
            <input type="text" id="city" name="city" placeholder="Город" required>
          </div>

          <div class="register__form">
            <input type="text" id="register_email" name="email" placeholder="Email" required>
          </div>

          <div class="register__form">
            <input type="password" id="register_password" name="password" placeholder="Пароль" required>
          </div>

          <button class="reg__enterBtn" type="submit" name="register">Зарегистрироваться</button>

          <div id="registerMessage" class="message">
          </div>

          <div class="register">
            <p class="register__text">Уже есть аккаунт?</p>
            <p class="register__text" id="showLoginForm">Войти</p>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script src="/js/code.jquery.com_jquery-3.7.0.min.js"></script>
  <script>
    $(document).ready(function() {

      $("#loginForm").show();
      $("#registrationForm").hide();


      $('#showLoginForm').click(function() {
        $("#loginForm").show();
        $("#registrationForm").hide();
        return false;
      });

      $('#showRegistrationForm').click(function() {
        $("#loginForm").hide();
        $("#registrationForm").show();
        return false;
      });
    });
  </script>
  <script>
    $(document).ready(function() {

      function registerUser(userData) {
        $.ajax({
          type: "POST",
          url: "/include/ajax/register.php", 
          data: userData,
          success: function(response) {
            $("#registerMessage").html(response);
          },
          error: function(xhr, status, error) {
            console.error("Ошибка при регистрации: " + error);
          }
        });
      }

      $("#registrationForm").submit(function(event) {
        event.preventDefault();

        var name = $("#name").val();
        var surname = $("#surname").val();
        var city = $("#city").val();
        var email = $("#register_email").val();
        var password = $("#register_password").val();

        var userData = {
          name: name,
          surname: surname,
          city: city,
          email: email,
          password: password,
          register: true
        };

        registerUser(userData);
      });
    });
  </script>

  <script>
    $(document).ready(function() {

      function loginUser(userData) {
        $.ajax({
          type: "POST",
          url: "/include/ajax/login.php",
          data: userData,
          success: function(response) {
            if (response === "success") {

              window.location.href = "/index.php";
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