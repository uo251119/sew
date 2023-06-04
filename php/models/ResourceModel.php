<?php
class ResourceModel extends Database
{
    public function getResources($limit = "", $idRecurso = "")
    {
        if (empty($idRecurso)) {
            if (!empty($limit)) {
                return $this->select("SELECT * FROM recursos ORDER BY id DESC LIMIT " . $limit);
            } else {
                return $this->select("SELECT * FROM recursos ORDER BY id DESC");
            }
        } else {
            if (!empty($limit)) {
                return $this->select("SELECT * FROM recursos "
                    . "WHERE id = '" . $idRecurso . "' ORDER BY id DESC LIMIT " . $limit);
            } else {
                return $this->select("SELECT * FROM recursos "
                    . "WHERE id = '" . $idRecurso . "' ORDER BY id");
            }
        }

    }

    public function getResource($id, $limit = "")
    {
        if (!empty($limit)) {
            return $this->select("SELECT * FROM recursos WHERE id = " . $id . " ORDER BY id DESC LIMIT " . $limit);
        } else {
            return $this->select("SELECT * FROM recursos WHERE id = " . $id . " ORDER BY id");
        }
    }

    public function setResources($data)
    {
        $fields = "";

        if (
            empty($data["descripcion"])
            || empty($data["id_tipo"])
            || empty($data["limite"])
            || empty($data["precio"])
        ) {
            if (empty($data["descripcion"])) {
                $fields = $fields . '[descripcion]';
            }

            if (empty($data["id_tipo"])) {
                $fields = $fields . '[id_tipo]';
            }

            if (empty($data["limite"])) {
                $fields = $fields . '[limite]';
            }

            if (empty($data["precio"])) {
                $fields = $fields . '[precio]';
            }

            return [
                "response" => "Los siguientes campos son requeridos para la creación del elemento: "
                . $fields,
                "insert" => FALSE
            ];
        }


        return $this->insert("INSERT INTO recursos (descripcion, id_tipo, limite, precio) "
            . "VALUES ('" . $data["descripcion"] . "', '" . $data["id_tipo"] . "', '" . $data["limite"] . "', '" . $data["precio"] . "')");
    }

    public function updateResources($data, $id)
    {
        $fields = "";

        if (!empty($data["descripcion"])) {
            $fields = $fields . "SET descripcion = '" . $data["descripcion"] . "'";
        }

        if (!empty($data["id_tipo"])) {
            if (empty($fields)) {
                $fields = $fields . "SET id_tipo = '" . $data["id_tipo"] . "'";
            } else {
                $fields = $fields . ", id_tipo = '" . $data["id_tipo"] . "'";
            }
        }

        if (!empty($data["precio"])) {
            if (empty($fields)) {
                $fields = $fields . "SET precio = '" . $data["precio"] . "'";
            } else {
                $fields = $fields . ", precio = '" . $data["precio"] . "'";
            }
        }

        if (!empty($data["limite"])) {
            if (empty($fields)) {
                $fields = $fields . "SET limite = '" . $data["limite"] . "'";
            } else {
                $fields = $fields . ", limite = '" . $data["limite"] . "'";
            }
        }

        return $this->update("UPDATE recursos " . $fields . " WHERE id = '" . $id . "'");
    }

    public function deleteResources($id)
    {
        return $this->delete("DELETE FROM recursos WHERE id = '" . $id . "'");
    }
}