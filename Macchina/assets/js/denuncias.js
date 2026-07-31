/**
 * Lógica específica del módulo: Gestión de Denuncias
 * Implementa DevExtreme DataGrid sin jQuery.
 */
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // 1. Instanciar el control del Offcanvas de Bootstrap 5
    const panelOffcanvasEl = document.getElementById('panelExpediente');
    const panelInstancia = new bootstrap.Offcanvas(panelOffcanvasEl);

    // 2. Mock de Datos (Simulando respuesta de la Base de Datos)
    const mockData = [
        { codigo: "D-20260730-A1B", fecha: "2026-07-30 08:30", tipo: "Campaña Anticipada", departamento: "Guatemala", municipio: "Mixco", estado: "NUEVA", direccion: "Bulevar Principal Zona 8", desc: "Vallas publicitarias del candidato X antes de tiempo." },
        { codigo: "D-20260729-XXY", fecha: "2026-07-29 14:15", tipo: "Día de Elecciones", departamento: "Quetzaltenango", municipio: "Xela", estado: "EN PROCESO", direccion: "Centro de Votación INVO", desc: "Acarreo de personas en bus amarillo." },
        { codigo: "D-20260728-ZZ8", fecha: "2026-07-28 09:00", tipo: "Prohibición Electoral", departamento: "Alta Verapaz", municipio: "Cobán", estado: "TIPIFICADA", direccion: "Parque Central", desc: "Regalo de víveres con logos de partido." }
    ];

    // 3. Renderizar y Configurar el DataGrid (Vanilla JS API de DevExtreme)
    const dataGridElement = document.getElementById("gridDenuncias");
    
    if (dataGridElement) {
        const gridInstance = new DevExpress.ui.dxDataGrid(dataGridElement, {
            dataSource: mockData,
            showBorders: true,
            columnAutoWidth: true,
            rowAlternationEnabled: true,
            hoverStateEnabled: true, // Efecto hover para indicar que son clickeables
            
            // Configuración de Búsqueda y Filtros
            searchPanel: {
                visible: true,
                width: 300,
                placeholder: "Buscar expediente, depto, tipo..."
            },
            filterRow: { visible: true },
            headerFilter: { visible: true },
            
            // Paginación
            paging: { pageSize: 15 },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [15, 30, 50],
                showInfo: true
            },
            
            // Definición de Columnas
            columns: [
                { dataField: "codigo", caption: "Código", alignment: "center", width: 150, cssClass: "fw-bold" },
                { dataField: "fecha", caption: "Fecha/Hora", dataType: "datetime", format: "yyyy-MM-dd HH:mm", width: 140 },
                { dataField: "tipo", caption: "Clasificación Inicial" },
                { dataField: "departamento", caption: "Departamento" },
                { dataField: "municipio", caption: "Municipio" },
                { 
                    dataField: "estado", 
                    caption: "Estado",
                    alignment: "center",
                    width: 130,
                    // CellTemplate para pintar Badges de colores según el texto
                    cellTemplate: function(container, options) {
                        let colorClass = "bg-secondary";
                        const estado = options.value.toUpperCase();
                        
                        if (estado === 'NUEVA') colorClass = 'bg-danger';
                        if (estado === 'EN PROCESO') colorClass = 'bg-primary';
                        if (estado === 'TIPIFICADA') colorClass = 'bg-info';
                        if (estado === 'RESUELTA') colorClass = 'bg-success';

                        const badge = document.createElement("span");
                        badge.className = `badge ${colorClass} w-100 py-2`;
                        badge.textContent = estado;
                        container.appendChild(badge);
                    }
                }
            ],

            // Evento: Al hacer clic en una fila (Abre el Offcanvas)
            onRowClick: function(e) {
                const rowData = e.data;
                
                // Inyectar datos en el panel (Simulando bind de datos)
                document.getElementById('lblCodigo').textContent = rowData.codigo;
                document.getElementById('lblEstado').textContent = rowData.estado;
                document.getElementById('lblTipo').textContent = rowData.tipo;
                document.getElementById('lblDepto').textContent = rowData.departamento;
                document.getElementById('lblMuni').textContent = rowData.municipio;
                document.getElementById('lblDireccion').textContent = rowData.direccion;
                document.getElementById('lblDescripcion').textContent = rowData.desc;

                // Color del badge de estado en el panel
                const lblEstado = document.getElementById('lblEstado');
                lblEstado.className = 'badge text-bg-secondary'; // reset
                if (rowData.estado === 'NUEVA') lblEstado.classList.replace('text-bg-secondary', 'text-bg-danger');
                if (rowData.estado === 'EN PROCESO') lblEstado.classList.replace('text-bg-secondary', 'text-bg-primary');
                if (rowData.estado === 'TIPIFICADA') lblEstado.classList.replace('text-bg-secondary', 'text-bg-info');

                // Abrir el panel lateral
                panelInstancia.show();
            }
        });

        // 4. Botón de exportar a Excel nativo de la vista (aprovechando DevExtreme)
        const btnExportar = document.getElementById('btnExportar');
        if (btnExportar) {
            btnExportar.addEventListener('click', () => {
                gridInstance.exportToExcel(false);
            });
        }
    }
});