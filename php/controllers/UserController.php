<?php
class UserController extends BaseController
{
    /**
     * "/users" Endpoint - Get list of users
     */
    public function getUsers($id = "", $limit = "")
    {
        try {
            $userModel = new UserModel();

            if (empty($id)) {
                if (!empty($limit)) {
                    $arrUsers = $userModel->getUsers($limit);
                } else {
                    $arrUsers = $userModel->getUsers();
                }
            } else {
                $arrUsers = $userModel->getUser($id);
            }

            $responseData = json_encode($arrUsers);

        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    /**
     * "/users" Endpoint - Post - set one user to table
     */
    public function setUsers($data)
    {
        try {
            $userModel = new UserModel();

            $arrUsers = $userModel->setUsers($data);
            $responseData = json_encode($arrUsers);

        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    /**
     * "/users" Endpoint - PUT - change data user to table
     */
    public function putUsers($data, $id)
    {

        try {
            $userModel = new UserModel();

            $arrUsers = $userModel->updateUsers($data, $id);
            $responseData = json_encode($arrUsers);

        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    /**
     * "/users/user_id" Endpoint - DELETE - delete one user to table
     */
    public function deleteUsers($id)
    {

        try {
            $userModel = new UserModel();
            $arrUsers = $userModel->deleteUsers($id);

            $responseData = json_encode($arrUsers);
        } catch (Error $e) {
            return json_encode(["message" => $e, "error" => true]);
        }

        return $responseData;
    }

    public function goToHome($result, $usuario)
    {
        $response = "";

        if ($result->insert) {
            $_SESSION['usuario'] = $usuario;

            $currentLink = "../php/reservas.php";
            header('Location: ' . $currentLink);
        } else {
            $response = $result->response;
        }

        return $response;
    }
}