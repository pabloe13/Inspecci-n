// Configuración de almacenamiento remoto (CustomStore)
const denunciaStore = new DevExpress.data.CustomStore({
  key: "id_denuncia",

  // Función de LECTURA
  load: async function () {
    try {
      const response = await fetch("?url=denuncias/api_listar");
      if (!response.ok) throw new Error("Error al cargar los datos");
      return await response.json();
    } catch (error) {
      console.error(error);
      throw "Fallo en la comunicación con la BD.";
    }
  },

  // Función de ACTUALIZACIÓN (Cuando editas un registro en el grid)
  update: async function (key, values) {
    // DevExtreme solo envía los campos que cambiaron (values).
    // Si cambió el estado, lo enviamos al backend.
    if (values.estado) {
      try {
        const response = await fetch("?url=denuncias/api_actualizar_estado", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            id_denuncia: key,
            nuevo_estado: values.estado,
          }),
        });

        const result = await response.json();
        if (result.status !== "success") {
          throw new Error(result.mensaje);
        }

        // Disparamos tostada de éxito
        DevExpress.ui.notify(
          "Estado actualizado correctamente",
          "success",
          3000,
        );
      } catch (error) {
        console.error(error);
        throw "Error al actualizar el estado.";
      }
    }
  },
});

// Instanciar DataGrid
const gridDenuncias = new DevExpress.ui.dxDataGrid(
  document.getElementById("gridDenuncias"),
  {
    dataSource: denunciaStore, // <--- Conectado a la BD
    showBorders: true,
    columnAutoWidth: true,
    searchPanel: { visible: true, placeholder: "Buscar..." },
    filterRow: { visible: true },
    paging: { pageSize: 15 },
    editing: {
      mode: "popup",
      allowUpdating: true, // Permitimos editar
      popup: {
        title: "Actualizar Estado del Expediente",
        showTitle: true,
        width: 500,
        height: 250,
      },
    },
    columns: [
      {
        type: "buttons",
        width: 110,
        caption: "Acciones",
        buttons: [
          {
            hint: "Ver Expediente",
            icon: "folder",
            onClick: function (e) {
              const id = e.row.data.id_denuncia;
              // Redirigir a la vista de detalle
              window.location.href = `?url=denuncias/detalle/${id}`;
            },
          },
        ],
      },
      // Aquí mantiene
      // s tus columnas, por ejemplo:
      {
        dataField: "token_seguimiento",
        caption: "Token",
        allowEditing: false,
        width: 150,
        alignment: "center",
      },
      {
        dataField: "fecha_registro",
        caption: "Fecha",
        dataType: "datetime",
        allowEditing: false,
      },
      {
        dataField: "departamento",
        caption: "Departamento",
        allowEditing: false,
      },
      {
        dataField: "nombre_categoria",
        caption: "Categoría",
        allowEditing: false,
      },
      {
        dataField: "estado",
        caption: "Estado",
        alignment: "center",
        lookup: {
          // Aquí podrías traer los estados desde otra tabla BD,
          // pero lo dejamos manual por ahora
          dataSource: [
            "NUEVA",
            "EN PROCESO",
            "TIPIFICADA",
            "RECHAZADA",
            "RESUELTA",
          ],
        },
        cellTemplate: function (container, options) {
          const estado = options.value;
          let colorClass = "bg-secondary";
          if (estado === "NUEVA") colorClass = "bg-danger";
          else if (estado === "EN PROCESO") colorClass = "bg-primary";
          else if (estado === "TIPIFICADA") colorClass = "bg-info text-dark";

          const badge = document.createElement("span");
          badge.className = `badge ${colorClass} px-3 py-2 rounded-pill`;
          badge.textContent = estado;
          container.appendChild(badge);
        },
      },
      // ... (resto de columnas)
    ],
  },
);
