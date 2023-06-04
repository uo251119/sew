<?php
require_once __DIR__ . "/nexo/nexo.php";
session_start();

$dataReserve = [
    'usuario' => $_SESSION['usuario'],
    'id_recurso' => $_POST['id'],
    'fecha' => $_POST['fecha'],
    'hora' => $_POST['hora'],
    'cantidad' => $_POST['cantidad']
];

$dataBudget = [
    'usuario' => $_SESSION['usuario'],
    'id_reserva' => "",
    'monto' => $_POST['precio']
];

$reserveController = new ReserveController();
$result = json_decode($reserveController->setReserves($dataReserve));
$reserveController->registerBudget($dataReserve, $dataBudget, $_POST["limite"], $result);