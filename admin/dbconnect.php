<?php
try {
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "ecommerce";
    $dsn = "mysql:host=$server;dbname=$db"; // ✅ Corrected here
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // echo "Connected successfully!";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
    echo $e->getMessage();
}
