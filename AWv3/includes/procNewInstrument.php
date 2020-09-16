<?php

  session_start();
  require 'db.php';
  require 'config.php';
  if (isset($_SESSION['user_id'])) {

  $message = '';

    if (!empty($_POST['instrumento']) && !empty($_POST['clr']) && !empty($_POST['txt'])) {
      $sql = "INSERT INTO instrumentos (Nombre, Color, Info, UserID, Img) VALUES (:instrumento, :clr, :txt, :userID, :img)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':instrumento', $_POST['instrumento']);
      $stmt->bindParam(':clr', $_POST['clr']);
      $stmt->bindParam(':txt', $_POST['txt']);
      $stmt->bindParam(':img', $_FILES['img']['name']);
      $stmt->bindParam(':userID', $_SESSION['user_id']);

      if ($stmt->execute()) {
        $message = 'Se ha creado correctamente';
      } else {
        $message = 'Lo sentimos, ha habido un problema al crear el archivo';
      }

      //Datos imagen
      if(!empty($_FILES['img']['name'])){
        $nombre_img = $_FILES['img']['name'];
        $tipo_img = $_FILES['img']['type'];
        $tam_img = $_FILES['img']['size'];
        $carpeta = $_SERVER['DOCUMENT_ROOT'] . RUTA_APP . 'img/';
        move_uploaded_file($_FILES['img']['tmp_name'], $carpeta.$nombre_img);
      }

    }
  }
  header("Location: ../instrumentos.php");
?>