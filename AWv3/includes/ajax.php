<?php

  session_start();
  require 'include/db.php';

  if (isset($_SESSION['user_id'])) {
    if (!empty($_POST['Título']) && !empty($_POST['Color']) && !empty($_POST['Texto'])) {
        $sql = "INSERT INTO posits (Título, Color, Texto, UserID) VALUES (:title, :clr, :txt, :userID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $_POST['Título']);
        $stmt->bindParam(':clr', $_POST['Color']);
        $stmt->bindParam(':txt', $_POST['Texto']);
        $stmt->bindParam(':userID', $_SESSION['user_id']);

        if ($stmt->execute()) {
          $message = 'Se ha creado correctamente';
        } else {
          $message = 'Lo sentimos, ha habido un problema al crear el pósit';
        }
      }
  }

?>