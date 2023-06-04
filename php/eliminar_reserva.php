<?php
require_once __DIR__ . "/nexo/nexo.php";

session_start();

$reserveController = new ReserveController();
$budgetModel = new BudgetModel();

$id = $_GET['id'];

$reserveController->deleteReserves($id);
$budgetModel->deleteBudgets($id);

header('Location: ' . 'presupuesto.php');