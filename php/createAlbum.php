<?php
class CreateAlbum
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

    public function newAlbum($nombre, $año, $discograficaId)
    {
        $statement = $this->connection->prepare('INSERT INTO album (titulo, año, discografica_id) VALUES (?, ?, ?)');
        $statement->bind_param('sii', $nombre, $año, $discograficaId);
        $statement->execute();

        header('location:createAlbum.php');
    }

    public function getCompanies()
    {
        $resultCompanies = $this->connection->query('SELECT * FROM discografica');
        return $resultCompanies->fetch_all(MYSQLI_ASSOC);
    }

    public function getAlbums()
    {
        $resultAlbums = $this->connection->query('SELECT * FROM album');
        return $resultAlbums->fetch_all(MYSQLI_ASSOC);
    }

}

$createAlbum = new CreateAlbum();

if (isset($_POST['nombre'], $_POST['año'], $_POST['discograficaId'])) {
    $createAlbum->newAlbum($_POST['nombre'], $_POST['año'], $_POST['discograficaId']);
}

$companies = $createAlbum->getCompanies();
$albums = $createAlbum->getAlbums();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="layout.css">
    <title>Crear nuevo álbum</title>
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

    <h1>Crear nuevo álbum</h1>
    <form action="createAlbum.php" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" />

        <label for="año">año</label>
        <input name="año" id="año" type="number" min="1900" max="2099" step="1" value="2000" />

        <label for="discograficaId">Discográfica</label>
        <?php if (count($companies) == 0) { ?>
            <p id="noCompanyError">No se ha encontrado ningúa discográfica en la base de datos</p>
        <?php } else { ?>
            <select name="discograficaId" id="discograficaId">
                <?php foreach ($companies as $company) { ?>
                    <option value="<?php echo $company['discografica_id'] ?>">
                        <?php echo $company['nombre'] ?>
                    </option>
                <?php } ?>
            </select>
        <?php } ?>


        <button type="submit">Crear</button>
    </form>

    <h2>Álbums:</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>ID Discográfica</th>
        </tr>
        <?php foreach ($albums as $album) { ?>
            <tr>
                <td>
                    <?php echo $album['album_id'] ?>
                </td>
                <td>
                    <?php echo $album['titulo'] ?>
                </td>
                <td>
                    <?php echo $album['discografica_id'] ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>