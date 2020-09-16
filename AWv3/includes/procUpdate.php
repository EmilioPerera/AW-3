<?php
  session_start();

  require 'db.php';
  require 'config.php';

    if (!empty($_POST['instr']) && !empty($_POST['clr']) && !empty($_POST['txt'])) {
      $sql = "UPDATE instrumentos SET Nombre = :instr, Color = :clr, Info = :txt, Img = :img, UserID = :userID WHERE ID = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':id', $_POST['instrumentID']);
      $stmt->bindParam(':instr', $_POST['instr']);
      $stmt->bindParam(':clr', $_POST['clr']);
      $stmt->bindParam(':txt', $_POST['txt']);
      $stmt->bindParam(':img', $_FILES['img']['name']);
      $stmt->bindParam(':userID', $_SESSION['user_id']);

      if ($stmt->execute()) {
        $message = 'Se ha actualizado correctamente';
      } else {
        $message = 'Lo sentimos, ha habido un problema al actualizar el archivo';
      }

      if(!empty($_FILES['img']['name'])){
        $nombre_img = $_FILES['img']['name'];
        $tipo_img = $_FILES['img']['type'];
        $tam_img = $_FILES['img']['size'];
        $carpeta = $_SERVER['DOCUMENT_ROOT'] . RUTA_APP . 'img/';
        move_uploaded_file($_FILES['img']['tmp_name'], $carpeta.$nombre_img);
      }
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Instrumentos UCM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/web.css">
    <script src="assets/lib/jquery-3.5.1.min.js"></script>
  </head>
  <body>
    <h1>Se ha actualizado correctamente</h1>
    <a href="../instrumentos.php">Volver</a>
  </body>

</html>