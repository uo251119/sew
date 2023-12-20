<?php
class CreateCompany
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

    public function newCompany($nombre)
    {
        $statement = $this->connection->prepare('INSERT INTO discografica (nombre) VALUES (?)');
        $statement->bind_param('s', $nombre);
        $statement->execute();

        header('location:createCompany.php');
    }

    public function getCompanies()
    {
        $resultCompanies = $this->connection->query('SELECT * FROM discografica');
        return $resultCompanies->fetch_all(MYSQLI_ASSOC);
    }
}

$createCompany = new CreateCompany();

if (isset($_POST['nombre'])) {
    $createCompany->newCompany($_POST['nombre']);
}

$companies = $createCompany->getCompanies();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Crear y consultar discográficas">

    <link rel="stylesheet" href="../estilo/estilo.css">
    <link rel="stylesheet" href="../estilo/layout.css">
    <title>Crear nueva discográfica</title>
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

    <h1>Crear nueva discográfica</h1>
    <form action="createCompany.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">

        <button type="submit">Crear</button>
    </form>

    <h2>Autores:</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
        <?php foreach ($companies as $company) { ?>
            <tr>
                <td>
                    <?php echo $company['discografica_id'] ?>
                </td>
                <td>
                    <?php echo $company['nombre'] ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>