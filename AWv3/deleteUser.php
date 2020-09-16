<?php
  session_start();

  require 'includes/db.php';
  $userID = $_GET["userID"];

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT ID, Nombre, Contraseña, Admin FROM users WHERE ID = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $users = $records->fetch(PDO::FETCH_ASSOC);

    $records = $conn->prepare("SELECT * FROM users WHERE ID = :userID");
    $records->bindParam(':userID', $userID);
    $records->execute();
    $accounts = $records->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Pósits UCM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/web.css">
    <script src="assets/lib/jquery-3.5.1.min.js"></script>
  </head>
  <body>

    <?php if(!empty($user)): 
      if($user["Admin"] === '1'){ ?>
      <br><br>
      <a href="logout.php"> Cerrar sesión </a><br><br>
      <a href="posits.php"> Volver </a><br>

      <br><h4>  ¿Quieres eliminar esta cuenta? También se borrarán todos los pósits que tenga guardados </h4>
      <table id = "tabla2" border="1">
        <?php
          foreach ($accounts as $acc) {
        ?>
        <th>Cuenta</th><th>Admin</th>
        <tr>
          <td><?php echo $acc['Nombre']?></td>
          <td><?php if ($acc['Admin'] === '1') echo "Sí"; else echo "No"; ?></td>
        </tr>
        <?php
          }
        ?>
        </table>

    <?php } endif; ?>

      <br><br><a href="includes/procDeleteUser.php?userID=<?php echo $acc["ID"];?>"> Eliminar cuenta </a><br><br>
      <a href="admin.php"> Cancelar </a><br>

  </body>

</html>