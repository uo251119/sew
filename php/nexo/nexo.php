<?php

define("PROJECT_ROOT_PATH", __DIR__ . "/../");

//Primeramente configuramos los datos del servidor
require_once PROJECT_ROOT_PATH . "/nexo/config.php";

//Llamo a la base de datos con sus modelos
require_once PROJECT_ROOT_PATH . "/models/Database.php";
require_once PROJECT_ROOT_PATH . "/models/UserModel.php";
require_once PROJECT_ROOT_PATH . "/models/ReserveModel.php";
require_once PROJECT_ROOT_PATH . "/models/ResourceModel.php";
require_once PROJECT_ROOT_PATH . "/models/BudgetModel.php";
require_once PROJECT_ROOT_PATH . "/models/TypeModel.php";

//Llamo a los controladores
require_once PROJECT_ROOT_PATH . "/controllers/BaseController.php";
require_once PROJECT_ROOT_PATH . "/controllers/UserController.php";
require_once PROJECT_ROOT_PATH . "/controllers/LoginController.php";
require_once PROJECT_ROOT_PATH . "/controllers/ReserveController.php";
require_once PROJECT_ROOT_PATH . "/controllers/ResourceController.php";
require_once PROJECT_ROOT_PATH . "/controllers/TypeController.php";