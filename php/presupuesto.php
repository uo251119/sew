<?php
include_once "encabezado.html";
require __DIR__ . "/nexo/nexo.php";
LoginController::userAuth();

if (!empty($_SESSION['usuario'])) {
    $reserveController = new ReserveController();
    $data = json_decode($reserveController->getBudgets($_SESSION['usuario']));
} else {
    $data = null;
}

?>

<?php if (!empty($data)) { ?>
    <main>
        <h1>Presupuesto</h1>

        <table>
            <caption>Detalle del presupuesto</caption>
            <tr>
                <th>Cliente</th>
                <th>Recursos</th>
                <th>Ocupantes</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Precio</th>
                <th>ELiminar</th>
            </tr>
            <tr>
                <?php
                $total = 0;
                foreach ($data as $dat) {
                    ?>
                    <td>
                        <?php echo $dat->nombre . " " . $dat->apellido ?>
                    </td>
                    <td>
                        <?php echo $dat->descripcion ?>
                    </td>
                    <td>
                        <?php echo $dat->cantidad ?>
                    </td>
                    <td>
                        <?php echo $dat->fecha ?>
                    </td>
                    <td>
                        <?php echo $dat->hora ?>
                    </td>
                    <td>
                        <?php echo $dat->precio ?> €
                    </td>

                    <td>
                        <a href="<?= "./eliminar_reserva.php?id=$dat->id" ?>">
                            Eliminar
                        </a>
                    </td>
                </tr>
                <?php
                $total = $total + $dat->precio;
                }
                ?>
        </table>

        <p>
            Total presupuesto:
            <?php echo "$total €"; ?>
        </p>

        <a href="./iniciar.php">Volver</a>
    </main>

<?php } else { ?>
    <main>
        <h1>Presupuesto</h1>
        <p>No hay presupuestos disponibles actualmente.</p>
        <a href="./reservas.php">Volver</a>
    </main>
<?php } ?>