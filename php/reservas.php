<?php
include_once "./encabezado.html";
require __DIR__ . "/nexo/nexo.php";
LoginController::userAuth();

$resourceController = new ResourceController();
$typeController = new TypeController();
$resources = json_decode($resourceController->getResources());
?>

<main>
    <section>
        <h1>Reserva de recursos</h1>

        <?php if (!empty($_GET['failed'])) { ?>
            <p>
                <?= json_decode($_GET['failed']) ?>
            </p>
        <?php } ?>
        <a href="./recurso.php">Nuevo recurso</a>

        <table>
            <caption>Recursos disponibles</caption>
            <tr>
                <th>Descripción</th>
                <th>Límite de ocupantes</th>
                <th>Precio</th>
                <th>Tipo</th>
                <th>Reservar</th>
            </tr>
            <?php
            foreach ($resources as $dat) {
                ?>
                <tr>
                    <td>
                        <?= $dat->descripcion ?>
                    </td>
                    <td>
                        <?= $dat->limite ?>
                    </td>
                    <td>
                        <?= $dat->precio ?> €
                    </td>
                    <td>
                        <?= json_decode($typeController->getTypes($dat->id_tipo))[0]->tipo ?>
                    </td>

                    <td>
                        <a href="<?= "./reservar.php?id=" . $dat->id ?>">
                            Reservar
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </section>
</main>

</body>

</html>