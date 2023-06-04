<?php
include_once "./encabezado.html";
require __DIR__ . "/nexo/nexo.php";
LoginController::userAuth();

$typeController = new TypeController();
$types = json_decode($typeController->getTypes());
?>

<main>
    <h1>Registrar Nuevo Recurso</h1>

    <form role="form" id="quickForm" method="post" action="nuevo_recurso.php">
        <label for="nombre">Descripción</label>
        <input type="text" name="descripcion" required placeholder="Descripción del recurso">
        <label for="direccion">Límite ocupantes</label>
        <input type="number" name="limite" required placeholder="Límite de ocupantes">

        <label for="capacidad">Precio</label>
        <input type="text" name="precio" required placeholder="Precio del recurso (€)">
        <label for="etiqueta">Tipo de recurso</label>
        <select name="tipo">
            <option value="" selected>Seleccione un tipo turístico</option>

            <?php foreach ($types as $dat) { ?>
                <option value="<?= $dat->id ?>"><?= $dat->tipo ?></option>
            <?php } ?>
        </select>

        <a type="back" href="./reservas.php">Volver</a>
        <input type="submit" value="Guardar">
    </form>

</main>