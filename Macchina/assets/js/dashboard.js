/** Lógica específica del módulo: Dashboard * Renderizado de gráficas con DevExtreme */
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // Datos simulados (En un entorno real, estos se pedirían por fetch() a la API)
    const datosTendencia = [
        { dia: "Lun", ciudadanas: 15, oficio: 5 },
        { dia: "Mar", ciudadanas: 20, oficio: 8 },
        { dia: "Mié", ciudadanas: 35, oficio: 12 },
        { dia: "Jue", ciudadanas: 25, oficio: 6 },
        { dia: "Vie", ciudadanas: 40, oficio: 10 },
        { dia: "Sáb", ciudadanas: 55, oficio: 2 },
        { dia: "Dom", ciudadanas: 60, oficio: 3 }
    ];

    const datosAnomalias = [
        { tipo: "Campaña Anticipada", cantidad: 120 },
        { tipo: "Prohibición Electoral", cantidad: 80 },
        { tipo: "Día de Elecciones", cantidad: 10 },
        { tipo: "Otros", cantidad: 40 }
    ];

    // 1. Inicializar Gráfica de Tendencia (Line Chart)
    if (document.getElementById('chartTendencia')) {
        $('#chartTendencia').dxChart({
            dataSource: datosTendencia,
            palette: 'Soft Pastel',
            commonSeriesSettings: {
                type: 'spline',
                argumentField: 'dia'
            },
            series: [
                { valueField: 'ciudadanas', name: 'Denuncias Ciudadanas', color: '#007bff' },
                { valueField: 'oficio', name: 'Solicitudes de Oficio', color: '#f0b323' }
            ],
            margin: { bottom: 20 },
            argumentAxis: {
                valueMarginsEnabled: false,
                discreteAxisDivisionMode: 'crossLabels',
                grid: { visible: true }
            },
            legend: {
                verticalAlignment: 'bottom',
                horizontalAlignment: 'center',
                itemTextPosition: 'bottom'
            },
            export: { enabled: false },
            tooltip: {
                enabled: true,
                customizeTooltip: function (arg) {
                    return { text: arg.valueText };
                }
            }
        });
    }

    // 2. Inicializar Gráfica de Distribución (Doughnut Chart)
    if (document.getElementById('chartAnomalias')) {
        $('#chartAnomalias').dxPieChart({
            size: { width: null },
            palette: 'bright',
            dataSource: datosAnomalias,
            series: [{
                argumentField: 'tipo',
                valueField: 'cantidad',
                label: {
                    visible: true,
                    connector: { visible: true, width: 1 },
                    customizeText: function(arg) {
                        return arg.valueText + " (" + arg.percentText + ")";
                    }
                }
            }],
            innerRadius: 0.65, // Lo convierte en un Doughnut
            legend: {
                visible: false // Ocultamos leyenda para ahorrar espacio, ya está en las etiquetas
            },
            tooltip: {
                enabled: true,
                format: 'millions'
            }
        });
    }
});