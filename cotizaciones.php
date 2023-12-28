<!--                     
mmmmm                     mmmmm 
MM        `7MM"""Mq.         MM 
MM          MM   `MM.        MM 
MM          MM   ,M9         MM 
MM          MMmmdM9          MM 
MM          MM  YM.          MM 
MM          MM   `Mb.        MM 
MM        .JMML. .JMM.       MM 
MM                           MM 
MMmmm                     mmmMM
-->
<?php $usr = "us3r"; $in = "m0ss"; ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ingreso</title>
        <link rel="stylesheet" href="../r3d/r4inb0w">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
        <script src="chart.umd.js.map"></script>
    </head>
    <body class="bodyCotizacion">
        <br><h1 class="bienvCotizacion">BIENVENIDO AL ÁREA DE COTIZACIÓN</h1>
        <?php
            require '../definiciones.php';
            echo menuPerfil2;
        ?><br>
    </body>

    <form method="post" action="" >
        <h2 class="formularioCajaGrande">Seleccione una tabla
            <select name="table" class="option">
                <option value="tabla1">Tabla de Barra</option>
                <option value="tabla2">Tabla de Linea</option>
                <option value="tabla3">Tabla de Doughnut</option>
            </select>
            <select name="anio" class="option">
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
            <input type="submit" value="Ver" class="btnEnviar">
        </h2>
    </form>

    <div class="cajaGrandeValores">
        <div class="chartPesos">
            <canvas id="myChart1" class="chartPesosCanvas"></canvas>
        </div>
    </div><br>

    <?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['table'])) { 

            if($_POST['table'] == 'tabla1') {
                require 'cotizacionesBackend.php';
            }
            else if($_POST['table'] == 'tabla2'){
                require 'cotizacionesBackendLine.php';

            }
            else if($_POST['table'] == 'tabla3'){
                require 'cotizacionesBackendPorDefecto.php';

            }
        }
    }
    ?>

</html>