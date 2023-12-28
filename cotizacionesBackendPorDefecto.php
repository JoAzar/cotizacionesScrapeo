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
<?php require_once '../revisarConexion.php';
    //BIBLIOTECA DOM
    require 'ruta';

    // URL de la página web a scrapea
    $url = "https://www.billetesargentinos.com.ar/articulos/cotizacion.htm"; 
    // Reemplaza esto con la URL de la página de la cual deseas extraer los datos

    // Crear una instancia de Simple HTML DOM
    $html = file_get_html($url);

    // Aquí debes seleccionar y extraer los valores específicos de la página utilizando selectores CSS o XPath
    $valores = [];
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["anio"])) {
            $buscarEnAnio = $_POST["anio"];
        }
    }

    // Utiliza el selector adecuado para capturar los valores de la página web correspondientes al año 2022
    foreach ($html->find('table tr') as $row) {
        $anio = $row->find('td b', 0);              // Capturar el primer elemento <b> dentro de la fila
        if($anio && $anio->plaintext == $buscarEnAnio){
            $celdas = $row->find('td');             // Capturar todas las celdas de la fila
            foreach($celdas as $celda){
                if($celda->plaintext != $buscarEnAnio){    // Excluir la celda que contiene el año
                    $valor = $celda->plaintext;
                    $valores[] = $valor;
                }
            }
        }
    }

    $json_valores = json_encode($valores);
?>

<script> 
    
    var valores = '<?php echo $json_valores; ?>';
    var datosDePhp = JSON.parse(valores);
    for (var i = 0; i < 12; i++) {
        var varName = 'var' + (i + 1);
        var value = datosDePhp[varName];
    }

    // Función para convertir una cadena con formato "x,xxxx" a un número flotante
    function convertToFloat(str) {
    return parseFloat(str.replace(',', '.'));
    }

    // Convertir los strings a floats y reemplazar los vacíos con ceros
    const datosFloats = datosDePhp.map(str => str.trim() === '' ? 0 : convertToFloat(str));

    const ctx2 = document.getElementById('myChart1');
    
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Cotización Historica, Pesos Argentinos',
                data: datosFloats,
                borderColor: 'rgb(211,211,211)',
                borderWidth: 3,
                spacing: 2,
                backgroundColor: [
                    
                    'rgb(255, 87, 51)',
                    'rgb(255, 108, 72)',
                    'rgb(255, 99, 132)',
                    'rgb( 255, 194, 72 )',
                    'rgb(254, 244, 120)',
                    'rgb(154, 111, 235)',
                    'rgb(5, 205, 86)',
                    'rgb(72, 255, 147)',
                    'rgb(51, 255, 193)',
                    'rgb(72, 191, 255)',
                    'rgb(4, 162, 235)',
                    
                    'rgb(255, 72, 72)',
                    ,
                ],
                hoverOffset: 12,
            }]
        }
    });

        
</script>