<?php
include "conexion.php";

$tipo = $_GET['tipo']; // "canales" o "videos"
$data = [];

if ($tipo === "canales") {
    $sql = "SELECT * FROM canales";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} elseif ($tipo === "videos") {
    $sql = "SELECT * FROM videos";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>
