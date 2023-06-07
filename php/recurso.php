<?php
include_once "./encabezado.html";
require __DIR__ . "/nexo/nexo.php";
LoginController::userAuth();

$typeController = new TypeController();
$types = json_decode($typeController->getTypes());
?>

<main>
    <h1>Registrar Nuevo Recurso</h1>

    <form id="quickForm" method="post" action="nuevo_recurso.php">
        <label for="nombre">Descripción</label>
        <input id="nombre" type="text" name="descripcion" required placeholder="Descripción del recurso">

        <label for="limite">Límite ocupantes</label>
        <input id="limite" type="number" name="limite" required placeholder="Límite de ocupantes">

        <label for="capacidad">Precio</label>
        <input id="capacidad" type="text" name="precio" required placeholder="Precio del recurso (€)">

        <label for="etiqueta">Tipo de recurso</label>
        <select id="etiqueta" name="tipo">
            <option value="" selected>Seleccione un tipo turístico</option>

            <?php foreach ($types as $dat) { ?>
                <option value="<?= $dat->id ?>"><?= $dat->tipo ?></option>
            <?php } ?>
        </select>

        <a href="./reservas.php">Volver</a>
        <input type="submit" value="Guardar">
    </form>
</main>