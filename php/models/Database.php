<?php
class Database
{
    protected $connection = null;

    public function __construct()
    {
        $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

        if (mysqli_connect_errno()) {
            throw new InvalidArgumentException("Could not connect to database.");
        }
    }

    public function select($query = "", $params = [])
    {
        $stmt = $this->selectQuery($query, $params);
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function insert($query = "", $params = [])
    {
        return $this->insertQuery($query, $params);
    }

    public function update($query = "", $params = [])
    {
        return $this->updateQuery($query, $params);
    }

    public function delete($query = "", $params = [])
    {
        return $this->deleteQuery($query, $params);
    }

    private function selectQuery($query = "", $params = [])
    {
        $stmt = $this->connection->prepare($query);

        if ($stmt === false) {
            throw new InvalidArgumentException("Unable to do prepared statement: " . $query);
        }

        if ($params) {
            $stmt->bind_param($params[0], $params[1]);
        }

        $stmt->execute();

        return $stmt;
    }

    private function insertQuery($query, $params = [])
    {
        $result = $this->connection->query($query);
        $response = [];

        if ($result === true) {
            $response = ["response" => "New record created successfully", "insert" => true];
        } else {
            $response = ["response" => mysqli_error($this->connection), "insert" => false];
        }

        return $response;
    }

    private function updateQuery($query, $params = [])
    {
        $result = $this->connection->query($query);
        $response = [];

        if ($result === true) {
            $response = ["response" => "Record updated successfully", "update" => true];
        } else {
            $response = ["response" => mysqli_error($this->connection), "update" => false];
        }

        return $response;
    }

    private function deleteQuery($query)
    {
        $result = $this->connection->query($query);
        $response = [];

        if ($result === true) {
            $response = ["response" => "Delete record created successfully", "delete" => true];
        } else {
            $response = ["response" => "Could not delete record", "delete" => false];
        }

        return $response;
    }
}