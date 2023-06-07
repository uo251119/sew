<?php
include_once "encabezado.html";
require __DIR__ . "/nexo/nexo.php";
LoginController::isAuth();
?>

<?php
$error = '';
if (!empty($_POST)) {
    $postdata = [
        'usuario' => $_POST['usuario'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'telefono' => $_POST['telefono'],
        'direccion' => $_POST['direccion'],
        'clave' => $_POST['clave']
    ];

    $userController = new UserController();
    $result = $userController->setUsers($postdata);
    $result = json_decode($result);

    $error = $userController->goToHome($result, $_POST['usuario']);
}
?>

<main>
    <h1>Regístrate</h1>

    <?php if (!empty($error)) { ?>
        <p>
            <?= $error ?>
        </p>
    <?php } ?>

    <form action="registro.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input id="usuario" name="usuario" type="text" placeholder="Ingresa tu usuario">

        <label for="clave">Contraseña:</label>
        <input id="clave" name="clave" type="password" placeholder="Ingresa tu clave">

        <label for="confirm_password">Confirmar contraseña:</label>
        <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirma tu clave">

        <label for="nombre">Nombre:</label>
        <input id="nombre" name="nombre" type="text" placeholder="Ingresa tu nombre">

        <label for="apellido">Apellidos:</label>
        <input id="apellido" name="apellido" type="text" placeholder="Ingresa tu apellido">

        <label for="telefono">Teléfono:</label>
        <input id="telefono" name="telefono" type="text" placeholder="Ingresa tu teléfono">

        <label for="direccion">Dirección:</label>
        <input id="direccion" name="direccion" type="text" placeholder="Ingresa tu dirección">

        <a href="../index.html">Volver</a>

        <input type="submit" value="Registrarse">
    </form>

    <a href="iniciar.php">
        ¿Ya tienes una cuenta? Inicia sesión aquí.</i>
    </a>

</main>

</body>

</html>