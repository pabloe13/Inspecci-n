document.addEventListener('DOMContentLoaded', async () => {
    'use strict';

    try {
        // 1. Obtener datos desde Oracle a través de nuestra API interna
        const response = await fetch('?url=dashboard/api_graficas');
        const data = await response.json();

        if (data.status !== 'success') {
            throw new Error(data.mensaje);
        }

        // 2. Procesar datos para Gráfica de Categorías (Dona)
        const labelsDona = [];
        const seriesDona = [];
        data.categorias.forEach(item => {
            labelsDona.push(item.categoria);
            // Oracle devuelve strings, hay que castear a entero
            seriesDona.push(parseInt(item.total)); 
        });

        const opcionesDona = {
            series: seriesDona.length > 0 ? seriesDona : [1], // [1] por si está vacío para que no colapse
            labels: labelsDona.length > 0 ? labelsDona : ['Sin datos'],
            chart: { type: 'donut', height: 320 },
            colors: ['#003366', '#d32f2f', '#fbc02d', '#1976d2', '#388e3c'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: false }
        };

        const chartDona = new ApexCharts(document.querySelector("#chartCategorias"), opcionesDona);
        chartDona.render();

        // 3. Procesar datos para Gráfica de Tendencia Mensual (Barras)
        const nombresMeses = {
            '01': 'Ene', '02': 'Feb', '03': 'Mar', '04': 'Abr', '05': 'May', '06': 'Jun',
            '07': 'Jul', '08': 'Ago', '09': 'Sep', '10': 'Oct', '11': 'Nov', '12': 'Dic'
        };
        
        const labelsMeses = [];
        const seriesMeses = [];
        
        data.mensual.forEach(item => {
            labelsMeses.push(nombresMeses[item.mes] || item.mes);
            seriesMeses.push(parseInt(item.total));
        });

        const opcionesBarras = {
            series: [{
                name: 'Denuncias Recibidas',
                data: seriesMeses
            }],
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            xaxis: { categories: labelsMeses },
            colors: ['#003366'],
            plotOptions: {
                bar: { borderRadius: 4, horizontal: false, columnWidth: '50%' }
            },
            dataLabels: { enabled: false }
        };

        const chartBarras = new ApexCharts(document.querySelector("#chartTendencia"), opcionesBarras);
        chartBarras.render();

    } catch (error) {
        console.error("Error cargando gráficas: ", error);
        // Opcional: Pintar un mensaje en los divs de los gráficos si falla la conexión
        document.querySelector("#chartCategorias").innerHTML = '<div class="text-danger p-3">Error al cargar datos.</div>';
        document.querySelector("#chartTendencia").innerHTML = '<div class="text-danger p-3">Error al cargar datos.</div>';
    }
});