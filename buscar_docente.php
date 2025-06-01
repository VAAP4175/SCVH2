<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="tabla.css">
    <link rel="stylesheet" href="menu_adm.css">
</head>
<!------------------------------------------------->
<body>
<header>
<h2>Lista de Docentes</h2>
</header>

<aside class="sidebar">
    <ul class="menu">
    <li class="active" onclick="window.location.href='inicio_adm.php'"><i>🏠</i>Inicio</li>
      <li onclick="window.location.href='adm_usuarios.php'"><i>👤</i>Usuarios</li>
      <li onclick="window.location.href='adm_grupos.php'"><i>📜</i>Grupos</li>
      <li onclick="window.location.href='adm_horarios.php'"><i>📄</i>Horarios</li>
      <li onclick="window.location.href='index.php'"><i>🔙</i>Salir</li>
    </ul>

</aside>
<main>
<?php
include('conexion.php');
//verificar si se ha enviado el formulario de busqueda
if (isset($_POST['buscar'])) {
    $filtro=$_POST['filtro'];
    $busqueda=$_POST['buscar'];

    //Usamos sentencia preparada para evitar inyeccion SQL
    $sql="SELECT*FROM maestros WHERE $filtro LIKE ?";// LIKE busca el registro
    $stmt=$conn->prepare($sql);
    $param="%$busqueda%";
    $stmt->bind_param("s",$param);
    $stmt->execute();
    $result=$stmt->get_result();
}else{
//si  no hay busqueda, mostramos todos los empleados
    $sql="SELECT*FROM maestros";
    $result=$conexion->query($sql);
}

if ($result->num_rows > 0) {
    echo"<table >
    <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Correo</th>
    <th>Usuario</th>
     <th colspan='2'>Acciones</th>
    </tr>";

    while($row=$result->fetch_assoc()){
        echo" <tr>
        <td>".$row['id_maestro']."</td>
        <td>".$row['nombre_completo']."</td>
        <td>".$row['correo']."</td>
        <td>".$row['usuario']."</td>
         <td><a href='eliminar.php?id=".$row['id_maestro']."'>Eliminar</a>
        <td><a href='actualizar.php?id=".$row['id_maestro']."'>Actualizar</a>
        
        </tr>";
    }
    echo"<table>";
    echo"<a href='adm_usuarios.php'>Regresar</a>";
}else{
    echo"0 resultados";
}

$conexion->close();
?>
</main>
<footer>UICSLP © 2025 </footer>
</body>
</html>