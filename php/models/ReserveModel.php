<?php
class ReserveModel extends Database
{
    public function getReserves($limit = "", $idReserva = "")
    {
        if (empty($idReserva)) {
            if (!empty($limit)) {
                return $this->select("SELECT * FROM reservas ORDER BY id DESC LIMIT " . $limit);
            } else {
                return $this->select("SELECT * FROM reservas ORDER BY id DESC");
            }
        } else {
            if (!empty($limit)) {
                return $this->select("SELECT * FROM reservas "
                    . "WHERE id = '" . $idReserva . "' ORDER BY id DESC LIMIT " . $limit);
            } else {
                return $this->select("SELECT * FROM reservas "
                    . "WHERE id = '" . $idReserva . "' ORDER BY id");
            }
        }
    }

    public function getReserve($id, $limit = "")
    {
        if (!empty($limit)) {
            return $this->select("SELECT * FROM reservas WHERE id = " . $id . " ORDER BY id DESC LIMIT " . $limit);
        } else {
            return $this->select("SELECT * FROM reservas WHERE id = " . $id . " ORDER BY id");
        }
    }

    public function getLastReserveId()
    {
        return $this->select("SELECT id FROM `reservas` ORDER BY id DESC LIMIT 1");
    }

    public function setReserves($data)
    {
        $fields = "";

        if (
            empty($data["usuario"])
            || empty($data["id_recurso"])
            || empty($data["fecha"])
            || empty($data["hora"])
            || empty($data["cantidad"])
        ) {
            if (empty($data["usuario"])) {
                $fields = $fields . '[usuario]';
            }

            if (empty($data["id_recurso"])) {
                $fields = $fields . '[id_recurso]';
            }

            if (empty($data["fecha"])) {
                $fields = $fields . '[fecha]';
            }

            if (empty($data["hora"])) {
                $fields = $fields . '[hora]';
            }

            if (empty($data["cantidad"])) {
                $fields = $fields . '[cantidad]';
            }

            return [
                "response" => "Los siguientes campos son requeridos para la creación del elemento: "
                . $fields,
                "insert" => false
            ];
        }

        return $this->insert("INSERT INTO reservas (usuario, id_recurso, fecha, hora, cantidad) "
            . "VALUES ('" . $data["usuario"] . "', '" . $data["id_recurso"] . "', '"
            . $data["fecha"] . "', '" . $data["hora"] . "', '" . $data["cantidad"] . "')");
    }

    public function updateReserves($data, $id)
    {
        $fields = "";

        if (!empty($data["cantidad"])) {
            $fields = $fields . "SET cantidad = '" . $data["cantidad"] . "'";
        }

        if (!empty($data["id_recurso"])) {
            if (empty($fields)) {
                $fields = $fields . "SET id_recurso = '" . $data["id_recurso"] . "'";
            } else {
                $fields = $fields . ", id_recurso = '" . $data["id_recurso"] . "'";
            }
        }

        if (!empty($data["fecha"])) {
            if (empty($fields)) {
                $fields = $fields . "SET fecha = '" . $data["fecha"] . "'";
            } else {
                $fields = $fields . ", fecha = '" . $data["fecha"] . "'";
            }
        }

        if (!empty($data["hora"])) {
            if (empty($fields)) {
                $fields = $fields . "SET hora = '" . $data["hora"] . "'";
            } else {
                $fields = $fields . ", hora = '" . $data["hora"] . "'";
            }
        }

        return $this->update("UPDATE reservas " . $fields . " WHERE id = '" . $id . "'");
    }

    public function deleteReserves($id)
    {
        return $this->delete("DELETE FROM reservas WHERE id = $id");
    }
}