<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrador</title>
  
  <style>
   header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background-color: rgb(21, 61, 108);
    color: rgb(212, 219, 225);
  
  }
  
 html, body {
  height: 100%;
  margin: 0;
  display: flex;
  flex-direction: column;
}

main {
  flex: 1;
  display: flex;
  justify-content: center; /* Centra horizontalmente */
  align-items: center;     /* Centra verticalmente */
}

  .logo {
    display: flex;
  }
  
  .img-logo {
    margin: auto;
    height: 50px;
    padding-right: 10px;
    border-radius: 1%;
  }
  
  .logo h2 {
    margin: 10px auto;
    font-size: 35px;
    text-align: center;
    font-family: 'Verdana';
  }
  .cuenta {
    display: flex;
    
  }
  
  .img-cuenta {
    margin: auto;
    height: 70px;
    padding-right: 8px;
    border-radius: 50%;
    width: 75px;
    height: 75px;
  }
  
  .grupos{
    display: flex;
  }
  
  .img-grupos {
    margin: auto;
    height: 70px;
    padding-right: 8px;
    border-radius: 50%;
    width: 75px;
    height: 75px;
  }
  
  .horarios {
    display: flex;
  }
  
  .img-horarios {
    margin: auto;
    height: 70px;
    padding-right: 8px;
    border-radius: 50%;
    width: 75px;
    height: 75px;
  }
  
  .salir {
    display: flex;
  }
  
  .img-salir {
    margin: auto;
    height: 60px;
    padding-right: 8px;
    border-radius: 50%;
    width: 85px;
    height: 95px;
  }
  
  .salir h2 {
    margin: 10px auto;
    font-size: 35px;
    text-align: center;
    font-family: 'Verdana';
  }
  
   .card {
  width: 350px;         /* Más ancho */
  min-height: 160px;    /* Menor altura para que no sea cuadrado */
  padding: 20px 10px;
  border-radius: 12px;
  box-shadow: 4px 8px 6px rgba(80, 69, 69, 0.2);
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 20px;
  transition: transform 0.3s ease;
  cursor: pointer;

  
  }


  .button-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 2 columnas iguales */
  gap: 40px; /* espacio entre los cuadros */
  justify-content: center;
  align-items: center;
}

.img-cuenta,
.img-grupos,
.img-horarios,
.img-salir {
  width: 80px;
  height: 80px;
}


  button {
    
  background-color: white; /* Color de fondo gris claro */
  border: 0px solid #414546; /* Borde gris claro */
  border-radius: 5px; /* Bordes redondeados */
  font-size: 18px;
  padding: 15px 20px; /* Relleno interno */
  margin: 1px; /* Margen entre botones */
  text-align: center; /* Texto centrado */
  text-decoration: none; /* Quita la decoración del texto */
  color: #000000; /* Color del texto gris oscuro */
  font-weight: bold; /* Texto en negrita */
  display: flex; /* Para alinear el icono y el texto */
  align-content: center;
  align-items: center; 
  height:  12vh;/* Alinea verticalmente el icono y el texto */
  gap: 10px; /* Espacio entre el icono y el texto */
  transition: background-color 0.3s ease; /* Transición suave al pasar el ratón */
  cursor: pointer;
  }
  
  footer{
    background-color: rgb(223, 131, 49);
    color: antiquewhite;
    padding: 10px;
    font-family:'Segoe UI';
    text-align:center;
  }
  

  </style>
</head>
<body>
  <header>
    <section class="logo">
      <img src="./imgPH/logoazul.jpg" alt="logo" class="img-logo">
      <h2>BIENVENIDO</h2>
    </section>
  </header>

  <main>
    <section class="button-container">
      <div class="card">
        <button onclick="window.location.href='adm_usuarios.php'">
          <section class="cuenta">
            <img src="./imgPH/cuenta.png" alt="cuenta" class="img-cuenta">
          </section>
          Usuarios
        </button>
      </div>

      <div class="card">
        <button onclick="window.location.href='adm_grupos.php'">
          <section class="grupos">
            <img src="./imgPH/grupos.jpg" alt="grupos" class="img-grupos">
          </section>
          Grupos
        </button>
      </div>

      <div class="card">
        <button onclick="window.location.href='adm_horarios.php'">
          <section class="horarios">
            <img src="./imgPH/horarios.jpg" alt="horarios" class="img-horarios">
          </section>
          Horarios
        </button>
      </div>

      <div class="card">
        <button onclick="window.location.href='index.php'">
          <section class="salir">
            <img src="./imgPH/salir.jpg" alt="salir" class="img-salir">
          </section>
          Salir
        </button>
      </div>
    </section>
  </main>

  <footer>
    UICSLP © 2025 
  </footer>
</body>
</html>
