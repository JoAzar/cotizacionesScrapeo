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
    $url = 'https://www.billetesargentinos.com.ar/articulos/cotizacion.htm'; // URL de la página web a scrapea
    // Crear una instancia de Simple HTML DOM
    $html = file_get_html($url);

    // Aquí debes seleccionar y extraer los valores específicos de la página utilizando selectores CSS o XPath
    $valores = [];

    function checkInternetConnection($url) {
        $headers = @get_headers($url);
        return ($headers && strpos($headers[0], '200') !== false);
    }
    
    

    // Luego, puedes usar la función para verificar la conexión antes de realizar cualquier operación que dependa de la conexión a internet.
    if (checkInternetConnection($url)) {
        // Tu código aquí para realizar las operaciones que requieren conexión a internet.
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["anio"])) {
                $buscarEnAnio = $_POST["anio"];
            }
        }
    } else {
        header("Location: ../error/error.php"); // Redireccionar a la página de error o hacer cualquier otra acción que consideres adecuada.
        exit;
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

<script> var valores = '<?php echo $json_valores; ?>';
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

    const ctx = document.getElementById('myChart1');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Cotización Historica, Pesos Argentinos',
                data: datosFloats,
                borderWidth: 3,
                backgroundColor: [
                    'rgba(255, 10, 10, 0.3)',
                    'rgba(255, 25, 25, 0.3)',
                    'rgba(255, 50, 50, 0.3)',
                    'rgba(255, 60, 60, 0.3)',
                    'rgba(255, 80, 80, 0.3)',
                    'rgba(255, 100, 100, 0.3)',
                    'rgba(254, 162, 235, 0.3)',
                    'rgba(154, 162, 235, 0.3)',
                    'rgba(124, 162, 235, 0.3)',
                    'rgba(124, 162, 235, 0.3)',
                    'rgba(44, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 10, 10, 0.3)',
                    'rgba(255, 15, 15, 0.3)',
                    'rgba(255, 50, 50, 0.3)',
                    'rgba(255, 60, 60, 0.3)',
                    'rgba(255, 80, 80, 0.3)',
                    'rgba(255, 100, 100, 0.3)',
                    'rgba(254, 162, 235, 0.3)',
                    'rgba(154, 162, 235, 0.3)',
                    'rgba(124, 162, 235, 0.3)',
                    'rgba(124, 162, 235, 0.3)',
                    'rgba(44, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                ]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>


