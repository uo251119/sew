<?php
require __DIR__ . "/nexo/nexo.php";
LoginController::userAuth();

$postdata = [
    'descripcion' => $_POST['descripcion'],
    'limite' => $_POST['limite'],
    'precio' => $_POST['precio'],
    'id_tipo' => $_POST['tipo']
];

$resourceController = new ResourceController();
$result = json_decode($resourceController->setResources($postdata));

var_dump($result);

$resourceController->goToHome($result);