document.addEventListener("DOMContentLoaded", () => {
  "use strict";

  // Verificamos si tenemos coordenadas válidas (distintas de 0.0)
  if (latitudDenuncia !== 0 && longitudDenuncia !== 0) {
    // Inicializar el mapa centrado en las coordenadas
    const map = L.map("mapaDenuncia").setView(
      [latitudDenuncia, longitudDenuncia],
      16,
    );

    // Capa de OpenStreetMap
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);

    // Colocar el marcador
    L.marker([latitudDenuncia, longitudDenuncia])
      .addTo(map)
      .bindPopup("<b>Ubicación aproximada al municipio</b>")
      .openPopup();
  } else {
    // Si no hay coordenadas, mostramos un mensaje en el div
    const mapaDiv = document.getElementById("mapaDenuncia");
    mapaDiv.style.backgroundColor = "#e9ecef";
    mapaDiv.style.display = "flex";
    mapaDiv.style.alignItems = "center";
    mapaDiv.style.justifyContent = "center";
    mapaDiv.innerHTML =
      '<div class="text-muted"><i class="fa-solid fa-map-location-dot fs-3 d-block text-center mb-2"></i>Coordenadas GPS no proporcionadas en esta denuncia.</div>';
  }
  // --- LÓGICA DE EXPORTACIÓN A PDF ---
  const btnExportar = document.getElementById("btnExportarPDF");

  if (btnExportar) {
    btnExportar.addEventListener("click", () => {
      // 1. Mostrar el encabezado oficial para el documento
      const headerOficial = document.getElementById("headerOficial");
      headerOficial.classList.remove("d-none");

      // 2. Elemento a convertir
      const elemento = document.getElementById("documentoPdf");

      // 3. Cambiar estado del botón para que el usuario sepa que está cargando
      const originalText = btnExportar.innerHTML;
      btnExportar.innerHTML =
        '<i class="fa-solid fa-spinner fa-spin me-2"></i> Generando...';
      btnExportar.disabled = true;

      // 4. Configuración del PDF (Tamaño carta, orientación Vertical)
      const opciones = {
        margin: 0.5, // media pulgada de margen
        filename: `Expediente_Inspeccion.pdf`, // Se podría concatenar el Token aquí
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true }, // useCORS permite que el mapa se imprima
        jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
      };

      // 5. Generar PDF
      html2pdf()
        .set(opciones)
        .from(elemento)
        .save()
        .then(() => {
          // Restaurar vista original
          headerOficial.classList.add("d-none");
          btnExportar.innerHTML = originalText;
          btnExportar.disabled = false;
        })
        .catch((err) => {
          console.error("Error al generar PDF: ", err);
          alert("Hubo un error al generar el documento.");
          btnExportar.innerHTML = originalText;
          btnExportar.disabled = false;
        });
    });
  }
});
