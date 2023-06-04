<?php
class BudgetModel extends Database
{
    public function getBudgets($limit = "")
    {
        if (!empty($limit)) {
            return $this->select("SELECT * FROM presupuestos ORDER BY id DESC LIMIT " . $limit);
        } else {
            return $this->select("SELECT * FROM presupuestos ORDER BY id DESC");
        }

    }

    public function getBudget($id, $limit = "")
    {
        if (!empty($limit)) {
            return $this->select("SELECT * FROM presupuestos WHERE id = " . $id . " ORDER BY id DESC LIMIT " . $limit);
        } else {
            return $this->select("SELECT * FROM presupuestos WHERE id = " . $id . " ORDER BY id");
        }
    }

    public function getBudgetByUser($usuario)
    {
        return $this->select("SELECT usu.nombre,
                                    usu.apellido,
                                    pre.*,
                                    rec.descripcion,
                                    rec.precio,
                                    res.cantidad,
                                    res.fecha,
                                    res.hora
                                    FROM usuarios usu
                                    INNER JOIN reservas res ON usu.usuario = res.usuario
                                    INNER JOIN recursos rec ON res.id_recurso = rec.id
                                    INNER JOIN presupuestos pre ON usu.usuario = pre.usuario AND pre.id_reserva = res.id
                                    WHERE usu.usuario = '$usuario' ORDER BY descripcion");
    }

    public function setBudgets($data)
    {
        $fields = "";

        if (empty($data["monto"]) || empty($data["id_reserva"]) || empty($data["usuario"])) {
            if (empty($data["monto"])) {
                $fields = $fields . '[monto]';
            }

            if (empty($data["id_reserva"])) {
                $fields = $fields . '[id_reserva]';
            }

            if (empty($data["usuario"])) {
                $fields = $fields . '[usuario]';
            }

            return [
                "response" => "Los siguientes campos son requeridos para la creación del elemento: "
                . $fields,
                "insert" => FALSE
            ];
        }

        return $this->insert("INSERT INTO presupuestos (id_reserva, usuario, monto) "
            . "VALUES ('" . $data["id_reserva"] . "', '" . $data["usuario"] . "', '" . $data["monto"] . "')");
    }

    public function updateBudgets($data, $id)
    {
        $fields = "";

        if (!empty($data["monto"])) {
            $fields = $fields . "SET monto = '" . $data["monto"] . "'";
        }

        return $this->update("UPDATE presupuestos " . $fields . " WHERE id = '" . $id . "'");
    }

    public function deleteBudgets($id)
    {
        return $this->delete("DELETE FROM presupuestos WHERE id = $id");
    }
}