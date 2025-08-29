<?php

require_once("dbconnect.php");


if($_SERVER['REQUEST_METHOD']== "GET" && $_GET['val'] == 'del') {
    try {
        $id = $_GET['id'];
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$id]);
        header("Location: viewInfo.php?show=products");

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}    
?>