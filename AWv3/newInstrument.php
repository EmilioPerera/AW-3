<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <instrumento>Nuevo instrumento</instrumento>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/web.css">
  </head>
  <body>

    <a href="instrumentos.php"> Volver </a><br>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Nuevo pósit</h1>

    <form action="includes/procNewInstrument.php" method="POST" enctype="multipart/form-data">
      <input name="instrumento" type="text" placeholder="Introduce el título del pósit">
      Color del pósit: <select name="clr">
       <option value="white">Blanco</option>
       <option value="red">Rojo</option>
       <option value="orange">Naranja</option>
       <option value="yellow">Amarillo</option>
       <option value="grey">Gris</option>
       <option value="blue">Azul</option>
       <option value="green">Verde</option>
    </select>
      <br><br><textarea name ="txt" rows="10" cols="50" placeholder="Introduce el texto del pósit"></textarea><br><br>
      Imagen adjunta: <input type="file" name="img" size="20"><br><br>
      <input type="submit" value="Añadir">
    </form>

  </body>
</html>