<?php
include("conexion.php");

$tipo   = $_GET['tipo'] ?? 'canales';
$pagina = $_GET['pagina'] ?? 1;
$itemsPorPagina = 6;
$offset = ($pagina - 1) * $itemsPorPagina;

if ($tipo === "canales") {
    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM canales LIMIT $offset, $itemsPorPagina";
} else {
    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM videos LIMIT $offset, $itemsPorPagina";
}

$result = $conexion->query($query);
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

// Total de registros
$totalRes = $conexion->query("SELECT FOUND_ROWS() as total");
$total = $totalRes->fetch_assoc()['total'];
$totalPaginas = ceil($total / $itemsPorPagina);

echo json_encode([
    "pagina" => (int)$pagina,
    "total_paginas" => $totalPaginas,
    "items" => $items
]);



// FUNCIONES DINAMICAS DE CARD 
<?php
include("conexion.php");

$tipo = $_GET['tipo'] ?? 'canales';
$pagina = $_GET['pagina'] ?? 1;
$itemsPorPagina = 6;
$offset = ($pagina - 1) * $itemsPorPagina;

if ($tipo === "canales") {
    $query = "SELECT * FROM canales LIMIT $offset, $itemsPorPagina";
    $resultado = $conexion->query($query);

    while ($row = $resultado->fetch_assoc()) {
        echo "
        <div class='col-md-4'>
          <div class='card card-custom h-100' onclick=\"window.location.href='detalle.php?tipo=canal&id={$row['id']}'\">
            <img src='{$row['imagen']}' class='card-img-top' alt='Imagen'>
            <div class='card-body'>
              <h5 class='card-title'>{$row['nombre']}</h5>
              <p class='card-text'>{$row['descripcion']}</p>
              <p class='text-muted'>📹 Videos: {$row['videos']} | 👀 Vistas: {$row['vistas']}</p>
            </div>
          </div>
        </div>";
    }
} else {
    $query = "SELECT * FROM videos LIMIT $offset, $itemsPorPagina";
    $resultado = $conexion->query($query);

    while ($row = $resultado->fetch_assoc()) {
        echo "
        <div class='col-md-4'>
          <div class='card card-custom h-100' onclick=\"window.location.href='detalle.php?tipo=video&id={$row['id']}'\">
            <img src='{$row['imagen']}' class='card-img-top' alt='Imagen'>
            <div class='card-body'>
              <h5 class='card-title'>{$row['titulo']}</h5>
              <p class='card-text'>{$row['descripcion']}</p>
              <p class='text-muted'>⏱️ Duración: {$row['duracion']} | 👀 Vistas: {$row['vistas']}</p>
            </div>
          </div>
        </div>";
    }
}

