<?php

namespace CFW\Network;

use PDO, PDOException;

class CRUD
{
    private function connect($host = null, $name = null, $user = null, $pass = null)
    {
        $host = $host ?? $_ENV['DB_HOST'];
        $name = $name ?? $_ENV['DB_NAME'];
        $user = $user ?? $_ENV['DB_USER'];
        $pass = $pass ?? $_ENV['DB_PASS'];

        try {
            $conn = new PDO("mysql:host=$host;dbname={$name}", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Unable to connect: " . $e->getMessage());
        }

        return $conn;
    }

    public function create($table, $data = []): void
    {
        $conn = $this->connect();
        $keys = [];
        $kvp = [];
        $params = [];

        foreach ($data as $key => $value) {
            array_push($keys, "`{$key}`");
            array_push($kvp, ":{$key}");
            $params[$key] = $value;
        }

        $key = implode(', ', $keys);
        $placeholders = implode(', ', $kvp);

        $sql = "INSERT INTO `{$table}` ({$key}) VALUES ({$placeholders}) LIMIT 1";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute($params);
        } catch (PDOException $pdo) {
            die("PDOException: " . print_r($pdo));
        }
    }

    public function read($table, $columns = "*", $conditional = null, $order = null, int $limit = null)
    {
        $conn = $this->connect();
        $params = [];

        $sql = "SELECT {$columns} FROM `{$table}`";
        if (isset($conditional) && $conditional !== '') {
            $sql .= " WHERE ";
            if (is_array($conditional)) {
                $where = [];
                $params = [];

                foreach ($conditional as $key => $value) {
                    array_push($where, "{$key} = :{$key}");
                    $params[$key] = $value;
                }
                $where = implode(" AND ", $where);
            }
            $sql .= $where;
        }

        if ($order !== null) {
            $sql .= " ORDER BY {$order}";
        }

        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";
        }

        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $pdo) {
            die("PDOException: " . print_r($pdo));
        }

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function update($table, $changes = [], $condition = []): void
    {
        $conn = $this->connect();

        $update = $params = $con = [];

        foreach ($changes as $key => $value) {
            array_push($update, "`{$key}` = :{$key}");
            $params[$key] = $value;
        }

        $updt = implode(", ", $update);

        foreach ($condition as $key => $value) {
            array_push($con, "`{$key}` = :where_{$key}");
            $params["where_" . $key] = $value;
        }

        $cond = implode(" AND ", $con);

        $sql = "UPDATE `{$table}` SET {$updt} WHERE {$cond} LIMIT 1";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $pdo) {
            die("PDOException: " . print_r($pdo));
        }
    }

    public function delete($table, $condition = []): void
    {
        $conn = $this->connect();
        $con = [];
        $params = [];

        foreach ($condition as $key => $value) {
            array_push($con, "{$key} = :{$key}");
            $params[$key] = $value;
        }

        $conditions = implode(" AND ", $con);

        try {
            $sql = "DELETE FROM {$table} WHERE {$conditions} LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $pdo) {
            die("PDOException: " . print_r($pdo));
        }
    }
}
