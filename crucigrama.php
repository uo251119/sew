<?php
class Record
{
    private $server;
    private $user;
    private $pass;
    private $dbname;

    public $nivel;

    public function __construct()
    {
        $this->server = 'localhost';
        $this->user = 'DBUSER2023';
        $this->pass = "DBPSWD2023";
        $this->dbname = "records";
    }

    public function nuevoRecord(string $name, string $surname, string $level, int $time)
    {
        $this->nivel = $level;

        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $stmt = $mysqli->prepare("INSERT INTO registro(nombre, apellidos, nivel, tiempo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $surname, $level, $time);

        $stmt->execute();
    }

    public function obtenerRecords()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $stmt = $mysqli->prepare("SELECT * FROM registro WHERE nivel = ? ORDER BY tiempo ASC LIMIT 10");
        $stmt->bind_param("s", $this->nivel);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}

if (!empty($_POST)) {
    $record = new Record();
    $record->nuevoRecord($_POST['name'], $_POST['surname'], $_POST['level'], $_POST['time']);
}
?>

<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="estilo/layout.css">
    <link rel="stylesheet" type="text/css" href="estilo/crucigrama.css">
    <link rel="icon" type="image/x-icon" href="multimedia/imagenes/favicon.ico">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title>Crucigrama Matemático</title>
</head>

<body>
    <h1>Crucigrama Matemático</h1>
    <nav>
        <ul>
            <li><a accesskey="P" tabindex="0" href="index.html">Página principal</a></li>
            <li><a accesskey="S" tabindex="0" href="sobremi.html">Sobre mí</a></li>
            <li><a accesskey="N" tabindex="0" href="noticias.html">Noticias</a></li>
            <li><a accesskey="A" tabindex="0" href="agenda.html">Agenda</a></li>
            <li><a accesskey="M" tabindex="0" href="meteorologia.html">Meteorología</a></li>
            <li><a accesskey="V" tabindex="0" href="viajes.php">Viajes</a></li>
            <li><a accesskey="J" tabindex="0" href="juegos.html">Juegos</a></li>
        </ul>
    </nav>
    <section>
        <h2>Elige un juego:</h2>
        <ul>
            <li><a href="memoria.html">Juego de Memoria</a></li>
            <li><a href="sudoku.html">Sudoku</a></li>
            <li><a href="crucigrama.php">Crucigrama Matemático</a></li>
            <li><a href="api.html">Temática Libre</a></li>
        </ul>
    </section>
    <h2>Crucigrama Matemático</h2>

    <button onclick="crucigrama.start(1);">Nivel Fácil</button>
    <button onclick="crucigrama.start(2);">Nivel Intermedio</button>
    <button onclick="crucigrama.start(3);">Nivel Difícil</button>

    <main></main>

    <script src="js/crucigrama.js"></script>
    <script>let crucigrama = new Crucigrama();</script>
    <script>
        addEventListener('keydown', (event) => {
            if (event.isComposing || event.keyCode === 229) {
                return;
            }
            if (event.key.match(/^[\d+\-*/]$/g)) {
                console.log(event.key);
                let cellClicked = false;

                Array.from(document.getElementsByTagName('p')).forEach(element => {
                    if (element.getAttribute('data-state') == 'clicked') {
                        crucigrama.introduceElement(event.key);

                        cellClicked = true;
                    }
                });

                if (!cellClicked) {
                    alert('Ninguna celda ha sido seleccionada.');
                }
            }
        });
    </script>

    <?php
    if (!empty($_POST)) {
        ?>
        <section>
            <h2>Récords: nivel
                <?= $record->nivel ?>
            </h2>
            <ol>
                <?php
                foreach ($record->obtenerRecords() as $registro) {
                    ?>
                    <li>
                        <?= intval($registro['tiempo'] / 3600)
                            . ':' . intval($registro['tiempo'] % 3600 / 60)
                            . ':' . $registro['tiempo'] % 60 ?>
                        -
                        <?= $registro['nombre'] ?>
                        <?= $registro['apellidos'] ?>
                    </li>
                    <?php
                }
                ?>
            </ol>
        </section>
        <?php
    }
    ?>
</body>

</html>