<?php

  session_start();

  require 'includes/config.php';
  require 'includes/db.php';

  if (isset($_SESSION['user_id'])) {
    header('Location: '.RUTA_APP.'instrumentos.php');
  }

  if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT ID, Nombre, Contraseña FROM users WHERE Nombre = :username');
    $records->bindParam(':username', $_POST['username']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $password = $_POST['password'];

    //Contraseñas sin hash
    if ($_POST['password'] === $results['Contraseña']) {
      $_SESSION['user_id'] = $results['ID'];
      header("Location: /Examen AW v2/instrumentos.php");
    } else {
      $message = 'Lo siento, los datos introducidos no son correctos';
    }

    //Contraseñas con hash
    if (password_verify($password, $results['Contraseña'])) {
      $_SESSION['user_id'] = $results['ID'];
      header("Location: ".RUTA_APP."instrumentos.php");
    } else {
      $message = 'Lo siento, los datos introducidos no son correctos';
    }

  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/web.css">
  </head>
  <body>
    <?php require 'includes/header.php' ?>

    <h1>Login</h1>
    <span>Si todavía no tienes cuenta <a href="signup.php">regístrate</a></span>

    <form action="login.php" method="POST">
      <input name="username" type="text" placeholder="Introduce tu nombre de usuario">
      <input name="password" type="password" placeholder="Introduce tu contraseña">
      <input type="submit" value="Entrar">
    </form>
  </body>
</html>