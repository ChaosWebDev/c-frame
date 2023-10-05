<?php

function db_connect($dsn = [], $user = null, $pass = null)
{

    if ($dsn == null || empty($dsn)) {
        $host = $host ?? $_ENV['DB_HOST'];
        $name = $name ?? $_ENV['DB_NAME'];
    } else {
        $host = $dsn['host'];
        $name = $dsn['name'];
    }

    $user = $user ?? $_ENV['DB_USER'];
    $pass = $pass ?? $_ENV['DB_PASS'];

    $dsn = "mysql:host=$host;dbname={$name}";

    try {
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Unable to connect: " . $e->getMessage());
    }

    return $conn;
}

function db_prepared($conn, $sql, $params = [], $forceAA = false)
{
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($data) == 1 && $forceAA == false) {
        $data = $data[0];
    }

    return $data;
}

function db_count($conn, $sql): int
{
    $response = $conn->query($sql);
    return $response->fetchColumn();
}
