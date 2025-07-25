<!-- ------------------------------------------------------------------------------- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="menu_adm.css">
    <link rel="stylesheet" href="actualizar.css">
</head>
<body>
<header>
<h2>Actualizar Usuarios</h2>
</header>
<section>
    <div class="sidebar">
    <ul class="menu">
    <li class="active" onclick="window.location.href='inicio_adm.php'"><i>🏠</i>Inicio</li>
      <li onclick="window.location.href='adm_usuarios.php'"><i>👤</i>Usuarios</li>
      <li onclick="window.location.href='adm_grupos.php'"><i>📜</i>Grupos</li>
      <li onclick="window.location.href='adm_horarios.php'"><i>📄</i>Horarios</li>
      <li onclick="window.location.href='index.php'"><i>🔙</i>Salir</li>
    </ul>
</section>
<main>
<section class="registro">
<article>
<form action="" method="post">
        <input type="text" id="nombre" name="name" placeholder="Nombre" required> <br><br>
                        <input type="text"  name="email" placeholder="Correo" required> <br><br>
                        <input type="password"  name="password" placeholder="Contraseña" required> <br><br>

                        
                        <button type="submit">Actualizar</button>
        <button type="button" onclick="window.location.href='adm_usuarios.php'">Regresar</button>
        <?php
include('conexion.php');

if (isset($_GET['id'])) {
    $id=intval($_GET['id']); //intval si es de tipo texto lo pasa a numerico

    $sql= "SELECT*FROM alumnos WHERE id_alumno=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result=$stmt->get_result();

    if ($result->num_rows>0) {
        $row=$result->fetch_assoc();
        $nombre=$row['nombre_completo'];
        $correo=$row['usuario'];
        $contraseña=$row['contrasena'];
        
    }else{
        echo"Registro no encontrado. ";
        exit();
    }
    $stmt->close();
}else{
    echo"No se ha proporciado un ID valido.";
    exit();
}

if ($_SERVER['REQUEST_METHOD']=="POST") {
    $nombre=$_POST['name'];
    $correo=$_POST['email'];
    $contraseña=password_hash($_POST['password'],PASSWORD_DEFAULT);
   

    $sql="UPDATE alumnos SET nombre_completo=?,usuario=?,contrasena=? WHERE id_alumno=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("sssi",$nombre,$correo,$contraseña,$id);

    if ($stmt->execute()===TRUE) {
        echo"✅ Registro actualizado exitosamente";
    }else{
        echo"❌ Error al actualizar el registro ". $stmt->error;
    }
    $stmt->close();
}
?>
</form>
</article>
</section>
</main>
<footer>UICSLP © 2025</footer>
</body>
</html>