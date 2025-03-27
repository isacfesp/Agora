const options = {
    responsive: true,
    maintainAspectRatio: false,
};

const renderChart = (id, type, data) => {
    new Chart(document.getElementById(id), {
        type: type,
        data: data,
        options: options,
    });
};

const totalInscripcionesData = {
    labels: ['Total Inscripciones'],
    datasets: [{
        label: 'Inscripciones',
        data: [inscritosTotal],
        backgroundColor: 'rgba(75, 192, 192, 0.6)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
    }]
};

const inscripcionesPorCursoData = {
    labels: ['Motonetas', 'Motocicletas', 'Inyección Electrónica', 'Sistema Eléctrico'],
    datasets: [{
        label: 'Inscripciones',
        data: [120, 150, 100, 80],
        backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
        ],
        borderWidth: 1
    }]
};

const tasaConversionData = {
    labels: ['Interesados', 'Inscritos'],
    datasets: [{
        label: 'Usuarios',
        data: [interesadosTotal, inscritosTotal],
        backgroundColor: ['rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)'],
        borderColor: ['rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
        borderWidth: 1
    }]
};

const horariosData = {
    labels: ['Semanal', 'Sabatino'],
    datasets: [{
        label: 'Inscripciones',
        data: [semanalTotal, sabatinoTotal],
        backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)'],
        borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
        borderWidth: 1
    }]
};

const ingresosPorMesData = {
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
    datasets: [{
        label: 'Ingresos ($)',
        data: [20000, 25000, 30000, 28000, 32000],
        backgroundColor: 'rgba(75, 192, 192, 0.6)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    }]
};

const tipoPagoData = {
    labels: ['Transferencia', 'Efectivo', 'Tarjeta'],
    datasets: [{
        label: 'Tipo de Pago',
        data: [110, 200, 140],
        backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)'],
        borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
        borderWidth: 1
    }]
};

const cuotasPagadasData = {
    labels: ['Pagadas', 'Pendientes'],
    datasets: [{
        label: 'Cuotas',
        data: [400, 50],
        backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],
        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
        borderWidth: 1
    }]
};

const nuevosRegistrosData = {
    labels: ['Día 1', 'Día 7', 'Día 15', 'Día 22', 'Día 30'],
    datasets: [{
        label: 'Nuevos registros',
        data: [10, 15, 20, 25, 30],
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
    }]
};

const regionesData = {
    labels: ['San Luis Potosí', 'Querétaro', 'CDMX', 'Guanajuato', 'Otros'],
    datasets: [{
        label: 'Registros',
        data: [150, 80, 60, 40, 20],
        backgroundColor: [
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)'
        ],
        borderColor: [
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)'
        ],
        borderWidth: 1
    }]
};

const initializeCharts = () => {
    renderChart('totalInscripciones', 'doughnut', totalInscripcionesData);
    renderChart('inscripcionesPorCurso', 'bar', inscripcionesPorCursoData);
    renderChart('tasaConversion', 'pie', tasaConversionData);
    renderChart('horarios', 'bar', horariosData);
    renderChart('ingresosPorMes', 'line', ingresosPorMesData);
    renderChart('tipoPago', 'bar', tipoPagoData);
    renderChart('cuotasPagadas', 'doughnut', cuotasPagadasData);
    renderChart('nuevosRegistros', 'line', nuevosRegistrosData);
    renderChart('regiones', 'pie', regionesData);
};

// Inicializar las gráficas cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    initializeCharts();
});