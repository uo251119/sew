<?php
class CreateAuthor
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

    public function newAuthor($nombre)
    {
        $statement = $this->connection->prepare('INSERT INTO autor (nombre) VALUES (?)');
        $statement->bind_param('s', $nombre);
        return $statement->execute();
    }

    public function getAuthors()
    {
        $resultAuthors = $this->connection->query('SELECT * FROM autor');
        return $resultAuthors->fetch_all(MYSQLI_ASSOC);
    }
}

$createAuthor = new CreateAuthor();

if (isset($_POST['nombre'])) {
    $createAuthor->newAuthor($_POST['nombre']);
}

$authors = $createAuthor->getAuthors();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="layout.css">
    <title>Crear nuevo autor</title>
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

    <h1>Crear nuevo autor</h1>
    <form action="createAuthor.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" />

        <button type="submit">Crear</button>
    </form>

    <h2>Autores:</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
        <?php foreach ($authors as $author) { ?>
            <tr>
                <td>
                    <?php echo $author['autor_id'] ?>
                </td>
                <td>
                    <?php echo $author['nombre'] ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>