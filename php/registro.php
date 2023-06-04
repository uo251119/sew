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
    <section>
        <h1>Regístrate</h1>
        <?php if (!empty($error)) { ?>
            <p>
                <?= $error ?>
            </p>
        <?php } ?>
        <form action="registro.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input name="usuario" type="text" placeholder="Ingresa tu usuario">
            <label for="clave">Contraseña:</label>
            <input name="clave" type="password" placeholder="Ingresa tu clave">
            <label for="confirm_password">Confirmar contraseña:</label>
            <input name="confirm_password" type="password" placeholder="Confirma tu clave">
            <label for="nombre">Nombre:</label>
            <input name="nombre" type="text" placeholder="Ingresa tu nombre">
            <label for="apellido">Apellidos:</label>
            <input name="apellido" type="text" placeholder="Ingresa tu apellido">
            <label for="telefono">Teléfono:</label>
            <input name="telefono" type="text" placeholder="Ingresa tu teléfono">
            <label for="direccion">Dirección:</label>
            <input name="direccion" type="text" placeholder="Ingresa tu dirección">

            <a type="back" href="../index.html">Volver</a>

            <input type="submit" value="Registrarse">
        </form>
    </section>

    <section>
        <a href="iniciar.php">
            ¿Ya tienes una cuenta? Inicia sesión aquí.</i>
        </a>
    </section>
</main>

</body>

</html>