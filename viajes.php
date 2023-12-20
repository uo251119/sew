<?php
class Carrusel
{
    private $pais;
    private $capital;

    public function __construct(string $pais, string $capital)
    {
        $this->pais = $pais;
        $this->capital = $capital;
    }

    public function obtenerImagenes()
    {
        $params = array(
            'api_key' => 'caa2f6c1ad344b58bfd3e76a81178454',
            'method' => 'flickr.photos.search',
            'text' => $this->pais,
            'format' => 'json',
            'nojsoncallback' => '1'
        );

        $encoded_params = array();
        foreach ($params as $k => $v) {
            $encoded_params[] = urlencode($k) . '=' . urlencode($v);
        }

        $url = "https://api.flickr.com/services/rest/?" . implode('&', $encoded_params);

        $response = file_get_contents($url);
        return json_decode($response);
    }

}

$carrusel = new Carrusel('San Cristóbal y nieves', 'Baseterre');
$carrusel->obtenerImagenes();

class Moneda
{
    private $monedaSalida;
    private $monedaEntrada;

    public function __construct(string $monedaEntrada, string $monedaSalida)
    {
        $this->monedaEntrada = $monedaEntrada;
        $this->monedaSalida = $monedaSalida;
    }

    public function convert(float $amount)
    {
        $params = array(
            'access_key' => '9a1a0ce59e6a662e5000c168b5e10408'
        );
        $encoded_params = array();
        foreach ($params as $k => $v) {
            $encoded_params[] = urlencode($k) . '=' . urlencode($v);
        }
        $url = 'http://api.exchangeratesapi.io/v1/latest?' . implode('&', $encoded_params);
        $response = file_get_contents($url);

        $json = json_decode($response);

        return $amount * floatval(json_decode($json->rates->AED));
    }
}

$amountIn = ' ';
$amountOut = ' ';
if (!empty($_POST)) {
    $amountIn = $_POST['input'];
    $moneda = new Moneda('EUR', 'XCD');
    $amountOut = $moneda->convert($_POST['input']);
}
?>

<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Funcionalidades varias para irse de viaje">

    <link rel="stylesheet" type="text/css" href="estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="estilo/viajes.css">
    <link rel="stylesheet" type="text/css" href="estilo/layout.css">
    <link rel="icon" type="image/x-icon" href="multimedia/imagenes/favicon.ico">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/viajes.js"></script>

    <title>Viajes</title>
</head>

<body>
    <h1>Viajes</h1>
    <nav>
        <ul>
            <li><a accesskey="P" tabindex="0" href="index.html">Página principal</a></li>
            <li><a accesskey="S" tabindex="0" href="sobremi.html">Sobre mí</a></li>
            <li><a accesskey="N" tabindex="0" href="noticias.html">Noticias</a></li>
            <li><a accesskey="A" tabindex="0" href="agenda.html">Agenda</a></li>
            <li><a accesskey="M" tabindex="0" href="meteorologia.html">Meteorología</a></li>
            <li><a accesskey="V" tabindex="0" href="viajes.php">Viajes</a></li>
            <li><a accesskey="J" tabindex="0" href="juegos.html">Juegos</a></li>
            <li><a accesskey="L" tabindex="0" href="php/index.php">Temática Libre PHP</a></li>
        </ul>
    </nav>

    <section>
        <h2>Carrusel</h2>

        <button onclick="viajes.carruselPrev()">&#x2190;</button>

        <?php
        for ($i = 0; $i < 10; $i++) {
            $photo = $carrusel->obtenerImagenes()->photos->photo[$i]
                ?>
            <img src=<?=
                'https://live.staticflickr.com'
                . '/' . $photo->server
                . '/' . $photo->id
                . '_' . $photo->secret
                . '.jpg';
            ?> alt="Foto obtenida de Flickr">
            <?php
        }
        ?>
        <button onclick="viajes.carruselNext()">&#x2192;</button>
    </section>

    <main>
        <section>
            <h2>Convertidor de moneda</h2>
            <form action="#" method="post" name="currencyConversion">
                <label for="input">EUR:</label>
                <input id="input" name="input" type="text" value="<?= $amountIn ?>">
                <label for="output">XCD:</label>
                <input id="output" name="output" type="text" value="<?= $amountOut ?>" readonly="readonly">
                <input type="submit" value="Calcular">
            </form>
        </section>

        <button onclick="viajes.mapaEstatico()">Mapa estático</button>

        <section>
            <h2>Mapa dinámico</h2>
            <section>
                <h3>Mapa dinámico</h3>
            </section>
        </section>

        <script>let viajes = new Viajes();</script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6j4mF6blrc4kZ54S6vYZ2_FpMY9VzyRU&callback=viajes.mapaDinamicoGoogle.initMap"></script>

        <label for="fileInputRutas">Introduce un archivo de rutas (XML):</label>
        <input type="file" id="fileInputRutas" onchange="viajes.loadRutasFile(this.files)">
        <section id="rutas">
            <h2>Rutas cargadas:</h2>
        </section>

        <label for="fileInputAltimetria">Introduce varios archivos de altimetría (SVG):</label>
        <input type="file" id="fileInputAltimetria" onchange="viajes.loadAltimetriaFiles(this.files)" multiple>
        <section id="altimetrias">
            <h2>Altimetrías:</h2>
        </section>
    </main>

</body>

</html>