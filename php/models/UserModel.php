<?php
class UserModel extends Database
{
    public function getUsers()
    {
        return $this->select("SELECT * FROM usuarios ORDER BY id");
    }

    public function getUser($id)
    {
        return $this->select(
            "SELECT * FROM usuarios "
            . "WHERE (id = '" . $id . "' || usuario = '" . $id . "') "
            . "ORDER BY id"
        );
    }

    public function setUsers($data)
    {
        $fields = "";

        if (empty($data["usuario"]) || empty($data["nombre"]) || empty($data["clave"]) || empty($data["apellido"])) {
            if (empty($data["usuario"])) {
                $fields = $fields . '[usuario]';
            }

            if (empty($data["nombre"])) {
                $fields = $fields . '[nombre]';
            }

            if (empty($data["clave"])) {
                $fields = $fields . '[clave]';
            }

            if (empty($data["apellido"])) {
                $fields = $fields . '[apellido]';
            }

            return [
                "response" => "Los siguientes campos son requeridos para la creación del elemento: "
                . $fields,
                "insert" => false
            ];
        }

        if (empty($data["telefono"])) {
            $data["telefono"] = "";
        }

        if (empty($data["direccion"])) {
            $data["direccion"] = "";
        }

        return $this->insert(
            "INSERT INTO usuarios (usuario, telefono, direccion, nombre, clave, apellido) "
            . "VALUES ('" . $data["usuario"] . "', '" . $data["telefono"] . "', '" . $data["direccion"] . "' ,'"
            . $data["nombre"] . "' ,'" . sha1($data['clave']) . "', '" . $data['apellido'] . "')"
        );
    }

    public function deleteUsers($id)
    {
        return $this->delete("DELETE FROM usuarios WHERE (id = '" . $id . "' || usuario = '" . $id . "')");
    }

    public function updateUsers($data, $id)
    {
        $fields = "";

        if (!empty($data["usuario"])) {
            $fields = $fields . "SET usuario = '" . $data["usuario"] . "'";
        }

        if (!empty($data["nombre"])) {
            if (empty($fields)) {
                $fields = $fields . "SET nombre = '" . $data["nombre"] . "'";
            } else {
                $fields = $fields . ", nombre = '" . $data["nombre"] . "'";
            }
        }

        if (!empty($data["telefono"])) {
            if (empty($fields)) {
                $fields = $fields . "SET telefono = '" . $data["telefono"] . "'";
            } else {
                $fields = $fields . ", telefono = '" . $data["telefono"] . "'";
            }
        }

        if (!empty($data["direccion"])) {
            if (empty($fields)) {
                $fields = $fields . "SET direccion = '" . $data["direccion"] . "'";
            } else {
                $fields = $fields . ", direccion = '" . $data["direccion"] . "'";
            }
        }

        if (!empty($data["apellido"])) {
            if (empty($fields)) {
                $fields = $fields . "SET apellido = '" . $data["apellido"] . "'";
            } else {
                $fields = $fields . ", apellido = '" . $data["apellido"] . "'";
            }
        }

        if (!empty($data["clave"])) {
            if (empty($fields)) {
                $fields = $fields . "SET clave = '" . sha1($data['clave']) . "'";
            } else {
                $fields = $fields . ", clave = '" . sha1($data['clave']) . "'";
            }
        }

        return $this->update("UPDATE usuarios " . $fields . " WHERE (id = '" . $id . "' || usuario = '" . $id . "')");
    }

    public function loginUser($identifier, $clave)
    {
        if (empty($identifier) && empty($clave)) {
            return ["message" => "Debe llenar los campos para poder iniciar sesión", "logged" => false];
        } else {
            if (empty($identifier) && !empty($clave)) {
                return ["message" => "Debe llenar el campo de identificación", "logged" => false];
            }
            if (!empty($identifier) && empty($clave)) {
                return ["message" => "Debe llenar el campo contraseña", "logged" => false];
            }
        }

        echo "SELECT * FROM usuarios WHERE usuario = '" . $identifier . "' AND clave = '" . $clave . "' ORDER BY id";

        $user = $this->select(
            "SELECT * FROM usuarios WHERE usuario = '" . $identifier . "' AND clave = '" . $clave . "' ORDER BY id"
        );

        if (!empty($user)) {

            //Generate a random string.
            $token = openssl_random_pseudo_bytes(16);
            //Convert the binary data into hexadecimal representation.
            $token = bin2hex($token);

            return ["message" => "Sesión iniciada", "data" => $user, "logged" => true, "token" => $token];
        } else {
            return ["message" => "Error: Nombre de usuario o contraseña incorrecta.", "logged" => false];
        }
    }
}