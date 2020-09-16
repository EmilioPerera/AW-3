<?php
  session_start();

  require 'includes/db.php';
  require 'includes/config.php';
  $instrumentID = $_GET["instrumentID"];
  $opcSel = $_GET["opcSel"];
  $carpeta = RUTA_APP.'img/';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT ID, Nombre, Contraseña FROM users WHERE ID = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $users = $records->fetch(PDO::FETCH_ASSOC);

    $records = $conn->prepare("SELECT ID, UserID, Nombre, Info, Color, Img FROM instrumentos WHERE ID = '$instrumentID'");
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $instrumentos = $records->fetchAll(PDO::FETCH_ASSOC);

    $user = null;

    if (count($users) > 0) {
      $user = $users;
    }

  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Instrumentos UCM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/web.css">
    <script src="assets/lib/jquery-3.5.1.min.js"></script>
  </head>
  <body>

    <?php if(!empty($user)): ?>
      <br><br>
      <a href="logout.php"> Cerrar sesión </a><br><br>
      <a href="instrumentos.php"> Volver </a><br>
      <!-- Instrumentos -->
      <br><h4 class="txt">  ¿Quieres eliminar este pósit? </h4>
      <table id = "tabla2" border="1">
        <?php
          foreach ($instrumentos as $instrumento) {
        ?>
        <th>Instrumento</th><th>Texto</th>
        <tr>
          <td><?php echo $instrumento['Nombre']?></td>
          <td style="background-color: <?php echo $instrumento["Color"]; ?>; color: black;"><?php echo $instrumento['Info']?><br>
          <?php if(!empty($instrumento['Img'])){?>
            <img src="<?php echo $carpeta.$instrumento["Img"]?>" id = "imgPosit"></td>
            <?php }?>
          </td>
        </tr>
        <?php
          }
        ?>
        </table>

    <?php endif; ?>

      <br><br><a href="includes/procDelete.php?instrumentID=<?php echo $instrumento["ID"];?>"> Eliminar pósit </a><br><br>
      <a href="instrumentos.php"> Cancelar </a><br>

  </body>

</html>