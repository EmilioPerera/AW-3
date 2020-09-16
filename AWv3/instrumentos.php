<?php
  session_start();

  require 'includes/db.php';
  require 'includes/config.php';
  $carpeta = RUTA_APP.'img/';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT ID, Nombre, Contraseña, Admin FROM users WHERE ID = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $users = $records->fetch(PDO::FETCH_ASSOC);

    $records = $conn->prepare('SELECT ID, UserID, Nombre, Info, Color, Img FROM instrumentos WHERE UserID = :id');
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
      <h2> ¡Bienvenido a Instrumentos UCM, <?= $user['Nombre']; ?>!</h2>

      <a href="logout.php"> Cerrar sesión </a><br>

      <!-- Instrumentos -->
      <br><h4 class="txt"> Estos son los instrumentos que tienes guardados: </h4>
      <div class="div-tabla">
        <div class="div1">Instrumentos guardados</div>
          <div class="div2">Instrumento</div><div class="div2">Texto</div><div class="div2">Opciones</div>
          <?php
            foreach ($instrumentos as $instrumento) {
          ?>
            <div class="div3"><?php echo $instrumento['Nombre']?></div>
            <div class="div3" style="background-color: <?php echo $instrumento["Color"]; ?>; color: black;"><?php echo $instrumento['Info']?><br><br>
              <?php if(!empty($instrumento['Img'])){?>
              <img src="<?php echo $carpeta.$instrumento["Img"]?>" id = "imgInstrumento">
              <?php }?></div>
            <div class="div3"><a href="update.php?instrumentID=<?php echo $instrumento["ID"];?>&opcSel=<?php echo $instrumento["Color"];?>">Editar</a><br><a href="delete.php?instrumentID=<?php echo $instrumento["ID"];?>&opcSel=<?php echo $instrumento["Color"];?>">Eliminar</a></div>
          <?php
            }
          ?>
        </div>

        <!-- Nuevo instrumento -->
        <br>
        <a href="/AWv3/newInstrument.php">Crear nuevo instrumento</a><br>

    <?php endif; ?>

    <?php
      if($user["Admin"] === '1'){
        ?>
          <br><br><a href="admin.php">Administrar app</a>
        <?php
      } 
    ?>

    <br><br><h4 class="txt">Añadir mediante JS un nuevo instrumento:</b></h4>
    <form id="formAjax" method="POST">
      <label>Título</label>
      <input type="text2" name="Título" id = "Título"><br>
      <label>Texto</label>
      <textarea rows = "10" cols = "50" type="text2" name="Texto" id = "Texto"></textarea><br>
      <label>Color</label>
      <select name="Color" id = "Color">
       <option value="white">Blanco</option>
       <option value="red">Rojo</option>
       <option value="orange">Naranja</option>
       <option value="yellow">Amarillo</option>
       <option value="grey">Gris</option>
       <option value="blue">Azul</option>
       <option value="green">Verde</option>
       </select>
      <button id = btnAjax>Botón Ajax</button><br><br>
    </form>

  </body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('#btnAjax').click(function(){
      var datos = $('#formAjax').serialize();
      $.ajax({
        type: "POST",
        url: "includes/ajax.php",
        data: datos,
        success:function(){
        }
      });
      document.getElementById('formAjax').reset();
      location.reload();
      return false;
    });
  });
</script>