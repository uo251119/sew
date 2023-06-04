<?php
include_once "./encabezado.html";
require_once __DIR__ . "/nexo/nexo.php";
LoginController::userAuth();

if (!empty($_GET)) {
    $resourceController = new ResourceController();
    $data = json_decode($resourceController->getResources($_GET["id"]));
} else {
    $data = null;
}
?>

<?php if (!empty($data)) { ?>
    <main>
        <h1>Realizar una reserva</h1>

        <?php if (!empty($_GET['failed'])) { ?>
            <p>
                <?= json_decode($_GET['failed']) ?>
            </p>
        <?php } ?>

        <form role="form" id="quickForm" method="post" action="abm_reservar.php">
            <input type="hidden" name="id" value="<?php echo $data[0]->id; ?>">

            <label for="nombre">Recurso</label>
            <input type="text" value="<?php echo $data[0]->descripcion ?>" name="descripcion" readonly>
            <label>Precio</label>
            <input type="text" value="<?php echo $data[0]->precio ?>" name="precio" readonly>
            <label>Límite de ocupantes</label>
            <input type="number" value="<?php echo $data[0]->limite ?>" name="limite" readonly>
            <label>Cantidad de ocupantes que reservar</label>
            <input type="number" name="cantidad" required="">
            <label>Fecha de la reserva</label>
            <input type="date" name="fecha" required="">
            <label>Hora de la reserva</label>
            <input type="time" name="hora" required="">

            <a type="back" href="./reservas.php">Cancelar</a>
            <input type="submit" value="Reservar">
        </form>
    </main>

<?php } else { ?>
    <main>
        <p>Error: Se necesita un identificador para poder hacer la reserva o la
            información que está buscando ya no existe.</p>
        <a type="back" href="./reservas.php">Volver</a>
    </main>
<?php } ?>