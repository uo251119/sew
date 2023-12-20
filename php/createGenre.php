<?php
class CreateGenre
{
    private $host = 'localhost';
    private $user = 'DBUSER2023';
    private $pass = 'DBPSWD2023';
    private $nombreBD = 'musica';

    private $connection;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->nombreBD);
        if ($this->connection->connect_error) {
            die('Error al conectar');
        }
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }

    public function newGenre(string $nombre)
    {
        $sentencia = $this->connection->prepare('INSERT INTO genero (nombre) VALUES (?)');
        $sentencia->bind_param('s', $nombre);
        $sentencia->execute();

        header('location:createGenre.php');
    }

    public function getGenres()
    {
        $resultGenres = $this->connection->query('SELECT * FROM genero');
        return $resultGenres->fetch_all(MYSQLI_ASSOC);
    }
}

$createGenre = new CreateGenre();

if (isset($_POST['nombre'])) {
    $createGenre->newGenre($_POST['nombre']);
}

$genres = $createGenre->getGenres();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Crear y consultar géneros">

    <link rel="stylesheet" href="../estilo/estilo.css">
    <link rel="stylesheet" href="../estilo/layout.css">
    <title>Crear nuevo género</title>
</head>

<body>
    <nav>
        <a href="index.php">Página principal</a>
        <a href="createAlbum.php">Crear álbum</a>
        <a href="createSong.php">Crear canción</a>
        <a href="createAuthor.php">Crear autor</a>
        <a href="createGenre.php">Crear género</a>
        <a href="createCompany.php">Crear discográfica</a>
    </nav>

    <h1>Crear nuevo género</h1>
    <form action="createGenre.php" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre">

        <button type="submit">Crear</button>
    </form>

    <h2>Géneros:</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
        <?php foreach ($genres as $genre) { ?>
            <tr>
                <td>
                    <?php echo $genre['genero_id'] ?>
                </td>
                <td>
                    <?php echo $genre['nombre'] ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>