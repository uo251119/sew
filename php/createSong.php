<?php
class CreateSong
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

    public function newSong(string $nombre, int $albumId, int $autorId, int $generoId)
    {
        $statement = $this->connection->prepare('INSERT INTO cancion (nombre, album_id, autor_id, genero_id) VALUES (?, ?, ?, ?)');
        $statement->bind_param('siii', $nombre, $albumId, $autorId, $generoId);
        $statement->execute();

        header('location:createSong.php');
    }
    public function getSongs()
    {
        $resultSongs = $this->connection->query('SELECT * FROM cancion');
        return $resultSongs->fetch_all(MYSQLI_ASSOC);
    }

    public function getAlbums()
    {
        $resultAlbums = $this->connection->query('SELECT * FROM album');
        return $resultAlbums->fetch_all(MYSQLI_ASSOC);
    }

    public function getGenres()
    {
        $resultGenres = $this->connection->query('SELECT * FROM genero');
        return $resultGenres->fetch_all(MYSQLI_ASSOC);
    }

    public function getAuthors()
    {
        $resultAuthors = $this->connection->query('SELECT * FROM autor');
        return $resultAuthors->fetch_all(MYSQLI_ASSOC);
    }
}

$createSong = new CreateSong();

if (isset($_POST['nombre'], $_POST['albumId'], $_POST['autorId'], $_POST['generoId'])) {
    $createSong->newSong($_POST['nombre'], $_POST['albumId'], $_POST['autorId'], $_POST['generoId']);
}

$songs = $createSong->getSongs();
$albums = $createSong->getAlbums();
$authors = $createSong->getAuthors();
$genres = $createSong->getGenres();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Crear y consultar canciones">

    <link rel="stylesheet" href="../estilo/estilo.css">
    <link rel="stylesheet" href="../estilo/layout.css">
    <title>Crear nueva canción</title>
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

    <h1>Crear nueva canción</h1>
    <form action="createSong.php" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre">

        <?php if (count($albums) == 0) { ?>
            <p>Album</p>
            <p>No se ha encontrado ningún album en la base de datos</p>
        <?php } else { ?>
            <label for="albumId">Album</label>
            <select name="albumId" id="albumId">
                <?php foreach ($albums as $album) { ?>
                    <option value="<?php echo $album['album_id'] ?>">
                        <?php echo $album['titulo'] ?>
                    </option>
                <?php } ?>
            </select>
        <?php } ?>

        <?php if (count($authors) == 0) { ?>
            <p>Autor</p>
            <p>No se ha encontrado ningún autor en la base de datos</p>
        <?php } else { ?>
            <label for="autorId">Autor</label>
            <select name="autorId" id="autorId">
                <?php foreach ($authors as $authors) { ?>
                    <option value="<?php echo $authors['autor_id'] ?>">
                        <?php echo $authors['nombre'] ?>
                    </option>
                <?php } ?>
            </select>
        <?php } ?>

        <?php if (count($genres) == 0) { ?>
            <p>Género</p>
            <p>No se ha encontrado ningún género en la base de datos</p>
        <?php } else { ?>
            <label for="generoId">Género</label>
            <select name="generoId" id="generoId">
                <?php foreach ($genres as $genre) { ?>
                    <option value="<?php echo $genre['genero_id'] ?>">
                        <?php echo $genre['nombre'] ?>
                    </option>
                <?php } ?>
            </select>
        <?php } ?>


        <button type="submit">Crear</button>
    </form>

    <h2>Canciones:</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>ID Album</th>
            <th>ID Autor</th>
            <th>ID Género</th>
        </tr>
        <?php foreach ($songs as $song) { ?>
            <tr>
                <td>
                    <?php echo $song['cancion_id'] ?>
                </td>
                <td>
                    <?php echo $song['nombre'] ?>
                </td>
                <td>
                    <?php echo $song['album_id'] ?>
                </td>
                <td>
                    <?php echo $song['autor_id'] ?>
                </td>
                <td>
                    <?php echo $song['genero_id'] ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>