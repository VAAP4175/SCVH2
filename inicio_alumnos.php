<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas Deslizantes</title>
    <link rel="stylesheet" href="inicio_alumnos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header><h2>Horarios</h2></header>

    <main>
        <div class="carousel-container">
            <div class="table-slide active">
                <table class="LIA">
                    <tr><th><h2>Licenciatura en Informática Administrativa</h2></th></tr>
                    <tr>
                        <td>
                            <?php
                            $carrera = urlencode("LICENCIATURA EN INFORMATICA ADMINISTRATIVA");
                            echo "<button onclick=\"window.location.href='ver_Horario_A.php?carrera=$carrera'\">Ver</button>";
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table-slide">
                <table class="LD">
                    <tr><th><h2>Licenciatura en Derecho</h2></th></tr>
                    <tr>
                        <td>
                            <?php
                            $carrera = urlencode("LICENCIATURA EN DERECHO");
                            echo "<button onclick=\"window.location.href='ver_Horario_A.php?carrera=$carrera'\">Ver</button>";
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table-slide">
                <table class="II">
                    <tr><th><h2>Ingeniería Industrial</h2></th></tr>
                    <tr>
                        <td>
                            <?php
                            $carrera = urlencode("INGENIERIA INDUSTRIAL");
                            echo "<button onclick=\"window.location.href='ver_Horario_A.php?carrera=$carrera'\">Ver</button>";
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Indicadores de navegación -->
        <div class="dots-container">
            <span class="dot" onclick="changeTable(0)"></span>
            <span class="dot" onclick="changeTable(1)"></span>
            <span class="dot" onclick="changeTable(2)"></span>
        </div>
    </main>

    <footer>
        <div class="footer">
            <div>Universidad Intercultural de San Luis Potosí</div>
            <div><i class="fas fa-map-marker-alt"></i> Rectoría: Mariano Arista 925, Col. Tequisquiapan</div>
            <div><i class="fas fa-phone-alt"></i> Tel. (444)8138070</div>
            <div>San Luis Potosí, S.L.P. © 2025</div>
        </div>
    </footer>

    <script>
        let index = 0;

        function showNextTable() {
            let slides = document.querySelectorAll('.table-slide');
            let dots = document.querySelectorAll('.dot');

            slides.forEach((slide, i) => {
                slide.style.display = (i === index) ? 'block' : 'none';
                dots[i].classList.toggle('active', i === index);
            });

            index = (index + 1) % slides.length;
        }

        function changeTable(newIndex) {
            index = newIndex;
            showNextTable();
        }

        setInterval(showNextTable, 5000);
        showNextTable();
    </script>
</body>
</html>
