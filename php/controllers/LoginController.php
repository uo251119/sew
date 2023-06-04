<?php
class LoginController extends BaseController
{
    /**
     * "/login" Endpoint - Post init session
     */
    public function Login($data)
    {
        try {
            $userModel = new UserModel();

            $arrUsers = $userModel->loginUser($data["identifier"], $data["clave"]);
            $responseData = json_encode($arrUsers);

        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    public function goToHome($result, $usuario)
    {
        $response = "";

        if ($result->logged) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['token'] = $result->token;

            $currentLink = "../php/reservas.php";
            header('Location: ' . $currentLink);
        } else {
            $response = $result->message;
        }

        return $response;
    }

    public static function userAuth()
    {
        session_start();

        if (empty($_SESSION['usuario'])) {
            header('Location: ../php/iniciar.php');
        }
    }

    public static function isAuth()
    {
        session_start();

        if (!empty($_SESSION['usuario'])) {
            header('Location: ../php/reservas.php');
        }
    }

    public static function Logout()
    {
        session_start();

        $_SESSION["usuario"] = "";
        $_SESSION["token"] = "";

        header('Location: ../php/iniciar.php');
    }
}