/*   * Lógica específica del módulo: Solicitudes de Oficio * Configuración de DevExtreme DataGrid para inspectores. */
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // Mock de Datos de Solicitudes de Oficio
    const mockSolicitudes = [
        { codigo: "SOL-2026-001", fecha: "2026-07-30 11:00", inspector: "Julio Álvarez", depto: "Guatemala", tipificacion: "Campaña Anticipada", estado: "EN REVISIÓN" },
        { codigo: "SOL-2026-002", fecha: "2026-07-29 16:30", inspector: "Carlos Pérez", depto: "Escuintla", tipificacion: "Prohibición Electoral", estado: "TIPIFICADA" },
        { codigo: "SOL-2026-003", fecha: "2026-07-28 10:15", inspector: "Ana Gómez", depto: "Sacatepéquez", tipificacion: "Día de Elecciones", estado: "APROBADA" }
    ];

    const gridElement = document.getElementById("gridSolicitudes");

    if (gridElement) {
        new DevExpress.ui.dxDataGrid(gridElement, {
            dataSource: mockSolicitudes,
            showBorders: true,
            columnAutoWidth: true,
            rowAlternationEnabled: true,
            hoverStateEnabled: true,
            
            searchPanel: {
                visible: true,
                width: 300,
                placeholder: "Buscar solicitud, inspector..."
            },
            filterRow: { visible: true },
            
            paging: { pageSize: 15 },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [15, 30, 50],
                showInfo: true
            },
            
            columns: [
                { dataField: "codigo", caption: "Código", alignment: "center", width: 140, cssClass: "fw-bold" },
                { dataField: "fecha", caption: "Fecha Registro", dataType: "datetime", format: "yyyy-MM-dd HH:mm", width: 140 },
                { dataField: "inspector", caption: "Inspector Responsable" },
                { dataField: "depto", caption: "Departamento" },
                { dataField: "tipificacion", caption: "Tipificación Preliminar" },
                { 
                    dataField: "estado", 
                    caption: "Estado Interno",
                    alignment: "center",
                    width: 140,
                    cellTemplate: function(container, options) {
                        let colorClass = "bg-secondary";
                        const estado = options.value.toUpperCase();
                        
                        if (estado === 'EN REVISIÓN') colorClass = 'bg-warning text-dark';
                        if (estado === 'TIPIFICADA') colorClass = 'bg-info';
                        if (estado === 'APROBADA') colorClass = 'bg-success';

                        const badge = document.createElement("span");
                        badge.className = `badge ${colorClass} w-100 py-2`;
                        badge.textContent = estado;
                        container.appendChild(badge);
                    }
                }
            ],
            
            onRowClick: function(e) {
                // Aquí se puede abrir un offcanvas o redirigir al detalle del expediente interno
                console.log("Seleccionado expediente interno:", e.data.codigo);
            }
        });
    }
});