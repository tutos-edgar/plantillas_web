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
      cursor: pointer;
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

  <!-- Contenedor de Cards -->
  <div id="contenedor" class="row g-4"></div>

  <!-- Paginación -->
  <nav class="mt-4">
    <ul id="paginacion" class="pagination justify-content-center"></ul>
  </nav>
</div>

<script>
  let paginaActual = 1;
  const itemsPorPagina = 6;
  let datos = [];

  async function cargarDatos(tipo) {
    const response = await fetch(`getData.php?tipo=${tipo}`);
    datos = await response.json();
    paginaActual = 1;
    mostrarDatos(tipo);
  }

  function mostrarDatos(tipo) {
    const contenedor = document.getElementById("contenedor");
    contenedor.innerHTML = "";

    const inicio = (paginaActual - 1) * itemsPorPagina;
    const fin = inicio + itemsPorPagina;
    const pagina = datos.slice(inicio, fin);

    pagina.forEach(item => {
      let card = `
        <div class="col-md-4">
          <div class="card card-custom h-100" onclick="alert('Click en ${tipo === 'canales' ? item.nombre : item.titulo}')">
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
      contenedor.innerHTML += card;
    });

    generarPaginacion(datos.length);
  }

  function generarPaginacion(totalItems) {
    const totalPaginas = Math.ceil(totalItems / itemsPorPagina);
    const paginacion = document.getElementById("paginacion");
    paginacion.innerHTML = "";

    for (let i = 1; i <= totalPaginas; i++) {
      paginacion.innerHTML += `
        <li class="page-item ${i === paginaActual ? 'active' : ''}">
          <a class="page-link" href="#" onclick="cambiarPagina(${i})">${i}</a>
        </li>`;
    }
  }

  function cambiarPagina(num) {
    paginaActual = num;
    mostrarDatos(document.getElementById("selector").value);
  }

  document.getElementById("selector").addEventListener("change", () => {
    cargarDatos(document.getElementById("selector").value);
  });

  // Inicial: cargar canales
  cargarDatos("canales");
</script>

</body>
</html>
