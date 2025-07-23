<?php
include "../Modules/Contacts/metricasContactos.php";
include("../Modules/Alumnos/metricasAlumnos.php");
$interesados = isset($contador) ? intval($contador) : 0;
$inscritos = isset($contar) ? intval($contar) : 0;
$semanal = isset($semana) ? intval($semana) : 0;
$sabatino = isset($sabado) ? intval($sabado) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard CRM</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 20px;
      color: #333;
      overflow-x: hidden;
    }
    .container {
      max-width: 95%;
      margin: 0 auto;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #2c3e50;
    }
    .filters {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-bottom: 20px;
    }
    .filters select, .filters input {
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    .cards {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      flex: 1;
      text-align: center;
    }
    .card h3 {
      margin: 0;
      font-size: 18px;
      color: #555;
    }
    .card p {
      font-size: 24px;
      font-weight: 700;
      margin: 10px 0 0;
      color: #2c3e50;
    }
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
    }
    .chart-container {
      background: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      height: 300px;
    }
    canvas {
      max-width: 100%;
      height: 250px;
    }
    .table-container {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      margin-bottom: 20px;
    }
    .table-container h2 {
      margin-top: 0;
      color: #2c3e50;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table th, table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    table th {
      background-color: #f8f9fa;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Filtros -->
    <div class="filters">
      <select>
        <option>Últimos 7 días</option>
        <option>Últimos 30 días</option>
        <option>Este mes</option>
        <option>Personalizado</option>
      </select>
      <input type="date">
      <input type="date">
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="cards">
      <div class="card">
        <h3>Interesados</h3>
        <p><?php echo $interesados ?></p>
      </div>
      <div class="card">
        <h3>Inscritos</h3>
        <p><?php echo $inscritos ?></p>
      </div>
      <div class="card">
        <h3>Semanal</h3>
        <p><?php echo $semanal ?></p>
      </div>
      <div class="card">
        <h3>Sabatino</h3>
        <p><?php echo $sabatino ?></p>
      </div>
    </div>

    <!-- Gráficos Principales -->
    <div class="grid-container">
      <div class="chart-container">
        <canvas id="totalInscripciones"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="tasaConversion"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="ingresosPorMes"></canvas>
      </div>
    </div>

    <!-- Gráficos Secundarios -->
    <div class="grid-container">
      <div class="chart-container">
        <canvas id="inscripcionesPorCurso"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="horarios"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="tipoPago"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="cuotasPagadas"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="nuevosRegistros"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="regiones"></canvas>
      </div>
    </div>

    <!-- Tabla de Últimas Actividades -->
    <div class="table-container">
      <h2>Últimas Actividades</h2>
      <table>
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Actividad</th>
            <th>Usuario</th>
            <th>Detalles</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>2023-10-01</td>
            <td>Nuevo Contacto</td>
            <td>Juan Pérez</td>
            <td>Registro completado</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    const inscritosTotal = <?php echo $inscritos; ?>;
    const interesadosTotal = <?php echo $interesados; ?>;
    const semanalTotal = <?php echo $semanal; ?>;
    const sabatinoTotal = <?php echo $sabatino; ?>;
  </script>
  <script src="../Assets/JS/home-charts.js"></script>
</body>
</html>