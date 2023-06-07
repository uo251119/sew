<?php
include_once "encabezado.html";
require_once __DIR__ . "/nexo/nexo.php";
LoginController::isAuth();
?>
<?php
$error = '';
if (!empty($_POST)) {
    $postdata = [
        'identifier' => $_POST['usuario'],
        'clave' => $_POST['clave']
    ];

    $loginController = new LoginController();
    $result = $loginController->Login($postdata);
    $result = json_decode($result);

    $error = $loginController->goToHome($result, $_POST['usuario']);
}
?>

<main>
    <h1>Iniciar Sesión</h1>
    <?php if (!empty($error)) { ?>
        <p>
            <?= $error ?>
        </p>
    <?php } ?>
    <form action="iniciar.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input id="usuario" type="text" placeholder="Introduzca el nombre de usuario" name="usuario">

        <label for="clave">Contraseña:</label>
        <input id="clave" type="password" placeholder="Introduzca la contraseña" name="clave">

        <a href="../index.html">Volver</a>

        <input type="submit" value="Entrar">
    </form>

    <a href="registro.php">
        ¿Todavía no te has registrado? Hazlo aquí.</i>
    </a>
</main>

</body>

</html>