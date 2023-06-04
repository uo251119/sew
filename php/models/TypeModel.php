<?php
class TypeModel extends Database
{
    public function getTypes($limit = "")
    {
        if (!empty($limit)) {
            return $this->select("SELECT * FROM tipos ORDER BY id DESC LIMIT " . $limit);
        } else {
            return $this->select("SELECT * FROM tipos ORDER BY id DESC");
        }

    }

    public function getType($id, $limit = "")
    {
        if (!empty($limit)) {
            return $this->select("SELECT * FROM tipos WHERE id = " . $id . " ORDER BY id DESC LIMIT " . $limit);
        } else {
            return $this->select("SELECT * FROM tipos WHERE id = " . $id . " ORDER BY id");
        }
    }
}