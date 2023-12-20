<?php
include 'exportToCsv.php';

class Musica
{

    private $host = 'localhost';
    private $user = 'DBUSER2023';
    private $pass = 'DBPSWD2023';

    public function createDatabase($database)
    {
        $connection = new mysqli($this->host, $this->user, $this->pass);
        $connection->query('CREATE DATABASE ' . $_POST['databaseName']);
        $connection->close();

        $connection = new mysqli($this->host, $this->user, $this->pass, $database);

        $queries = array(
            'createTableAlbum' =>
                'CREATE TABLE `album` (
                `album_id` int(11) NOT NULL AUTO_INCREMENT,
                `titulo` varchar(30) NOT NULL,
                `año` year(4) NOT NULL,
                `discografica_id` int(11) NOT NULL,
                PRIMARY KEY(`album_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;',
            'createTableAutor' =>
                'CREATE TABLE `autor` (
                `autor_id` int(11) NOT NULL AUTO_INCREMENT,
                `nombre` varchar(30) NOT NULL,
                PRIMARY KEY(`autor_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;',
            'createTableCancion' =>
                'CREATE TABLE `cancion` (
                `cancion_id` int(11) NOT NULL AUTO_INCREMENT,
                `nombre` varchar(30) NOT NULL,
                `album_id` int(11) NOT NULL,
                `autor_id` int(11) NOT NULL,
                `genero_id` int(11) NOT NULL,
                PRIMARY KEY(`cancion_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;',
            'createTableDiscografica' =>
                'CREATE TABLE `discografica` (
                `discografica_id` int(11) NOT NULL AUTO_INCREMENT,
                `nombre` varchar(30) NOT NULL,
                PRIMARY KEY(`discografica_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;',
            'createTableGenero' =>
                'CREATE TABLE `genero` (
                `genero_id` int(11) NOT NULL AUTO_INCREMENT,
                `nombre` varchar(20) NOT NULL,
                PRIMARY KEY(`genero_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;'
        );

        foreach ($queries as $query) {
            $connection->query($query);
        }

        $connection->close();
    }

}

if (isset($_POST['databaseName'])) {
    $musica = new Musica();
    $musica->createDatabase($_POST['databaseName']);
}

if (isset($_POST['exportDatabaseFile'])) {
    $exportToCsv = new ExportToCsv($host, $user, $pass, $dbname);
    $exportToCsv->export($_POST['exportDatabaseFile']);
}

if (isset($_FILES["importDatabaseFile"]) && $_FILES["importDatabaseFile"]["error"] == UPLOAD_ERR_OK) {
    $uploadedFile = $_FILES["importDatabaseFile"]["tmp_name"];

    $exportToCsv = new ExportToCsv($host, $user, $pass, $dbname);
    $exportToCsv->import($uploadedFile);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="layout.css">

    <title>Página principal PHP</title>
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

    <h1>Página principal</h1>

    <main>
        <nav>
            <a href="../index.html">Volver a la aplicación principal</a>
        </nav>

        <form action="#" method="post">
            <label for="databaseName">Nombre de la base de datos:</label>
            <input type="text" name="databaseName" id="databaseName">

            <button type="submit">Crear base de datos</button>
        </form>

        <form action="#" method="post">
            <label for="importDatabaseFile">Importar base de datos (CSV):</label>
            <input type="file" name="importDatabaseFile" id="importDatabaseFile" accept=".csv">

            <button type="submit">Importar base de datos</button>
        </form>

        <form action="#" method="post">
            <label for="exportDatabaseFile">Nombre del archivo exportado:</label>
            <input type="text" name="exportDatabaseFile" id="exportDatabaseFile">

            <button type="submit">Exportar base de datos</button>
        </form>
    </main>

</body>

</html>