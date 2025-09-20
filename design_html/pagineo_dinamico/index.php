<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paginación de Cards</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-custom {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .card-custom:hover {
      transform: translateY(-5px);
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-4">
  <!-- Barra de título -->
  <div class="bg-danger text-white text-center py-3 rounded mb-4">
    <h2>🔥 Generar Visualizaciones</h2>
  </div>

  <!-- ComboBox -->
  <div class="mb-4">
    <label class="form-label">Seleccionar:</label>
    <select id="selector" class="form-select w-auto d-inline-block">
      <option value="canales">Canales</option>
      <option value="videos">Videos</option>
    </select>
  </div>
  
  <!-- Contenedor dinámico -->
  <div id="contenedor" class="row g-4"></div>

  <!-- Paginación -->
  <nav class="mt-4">
    <ul id="paginacion" class="pagination justify-content-center"></ul>
  </nav>
</div>

<script>
// Función para cargar datos desde PHP
function cargarDatos(tipo, pagina = 1) {
  fetch(`listar.php?tipo=${tipo}&pagina=${pagina}`)
    .then(res => res.json())
    .then(data => {
      // Render cards
      let html = "";
      data.items.forEach(item => {
        html += `
          <div class="col-md-4">
            <div class="card card-custom h-100 clickable">
              <img src="${item.imagen}" class="card-img-top" alt="Imagen">
              <div class="card-body">
                <h5 class="card-title">${tipo === "canales" ? item.nombre : item.titulo}</h5>
                <p class="card-text">${item.descripcion}</p>
                <p class="text-muted">
                  ${tipo === "canales"
                    ? `📹 Videos: ${item.videos} | 👀 Vistas: ${item.vistas}`
                    : `⏱️ Duración: ${item.duracion} | 👀 Vistas: ${item.vistas}`}
                </p>
              </div>
            </div>
          </div>`;
      });
      document.getElementById("contenedor").innerHTML = html;

      // Render paginación
      let pagHtml = "";
      for (let i = 1; i <= data.total_paginas; i++) {
        pagHtml += `
          <li class="page-item ${i === data.pagina ? 'active' : ''}">
            <a class="page-link" href="#" onclick="cargarDatos('${tipo}', ${i})">${i}</a>
          </li>`;
      }
      document.getElementById("paginacion").innerHTML = pagHtml;
    });
}

// Cambio de selector
document.getElementById("selector").addEventListener("change", e => {
  cargarDatos(e.target.value, 1);
});

// Inicial
cargarDatos("canales", 1);
</script>

</body>
</html>
