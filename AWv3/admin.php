<?php
  session_start();

  require 'includes/db.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT ID, Nombre, Contraseña, Admin FROM users WHERE ID = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $users = $records->fetch(PDO::FETCH_ASSOC);

    $records = $conn->prepare('SELECT * FROM users');
    $records->execute();
    $accounts = $records->fetchAll(PDO::FETCH_ASSOC);

    $records = $conn->prepare('SELECT ID, UserID, Título, Texto, Color, RutaImg FROM posits WHERE UserID = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $posits = $records->fetchAll(PDO::FETCH_ASSOC);

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

    <?php if(!empty($user)): 
      if($user["Admin"] === '1'){?>

      <h2> ¡Bienvenido a la gestión de Instrumentos UCM, <?= $user['Nombre']; ?>!</h2>

      <a href="logout.php"> Cerrar sesión </a><br><br>
      <a href="instrumentos.php"> Volver </a><br>

      <br><h4> Estos son las cuentas registradas en la app: </h4>
      <table id = "tabla" border="1">
        <th>Cuenta</th><th>Admin</th><th>Eliminar</th>
        <?php
          foreach ($accounts as $acc) {
        ?>     
        <tr>
          <td><?php echo $acc['Nombre']?></td>
          <td><?php if ($acc['Admin'] === '1') echo "Sí"; else echo "No"; ?></td>
          <td><a href="deleteUser.php?userID=<?php echo $acc["ID"];?>">Eliminar</a></td>
        </tr>
        <?php
          }
        ?>
        </table>

    <?php } endif;?>

  </body>
</html>