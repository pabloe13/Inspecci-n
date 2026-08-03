<?php if (!defined('APP_URL')) die('Acceso directo no permitido.'); ?>

<div class="admin-layout">
    <!-- Menú Lateral -->
    <?php require_once ROOT_PATH . '/includes/sidebar.php'; ?>

    <div class="main-wrapper">
        <!-- Barra Superior -->
        <?php require_once ROOT_PATH . '/includes/navbar.php'; ?>

        <!-- Área de Contenido Dinámico -->
        <main class="content-area">
            <div class="container-fluid p-0 h-100 d-flex flex-column">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="h3 mb-0 text-gray-800 fw-bold">Bandeja de Denuncias</h1>
                    <button class="btn btn-outline-secondary btn-sm shadow-sm" id="btnExportar">
                        <i class="fa-solid fa-file-excel me-1"></i> Exportar Vista
                    </button>
                </div>

                <!-- Contenedor del DataGrid DevExtreme -->
                <div class="card shadow-sm border-0 flex-grow-1">
                    <div class="card-body p-0">
                        <div id="gridDenuncias" style="height: calc(100vh - 175px);"></div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- PANEL LATERAL DERECHO (Offcanvas) PARA DETALLES DEL EXPEDIENTE -->
<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="panelExpediente" aria-labelledby="panelExpedienteLabel" style="width: 500px; border-left: 1px solid var(--tse-border);">

    <!-- Cabecera del Panel -->
    <div class="offcanvas-header bg-light border-bottom">
        <div>
            <h5 class="offcanvas-title fw-bold text-primary mb-1" id="panelExpedienteLabel">Expediente <span id="lblCodigo">Cargando...</span></h5>
            <span class="badge text-bg-warning" id="lblEstado">Estado</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>

    <!-- Cuerpo del Panel -->
    <div class="offcanvas-body p-0">
        <!-- Navegación por Pestañas -->
        <ul class="nav nav-tabs nav-justified bg-light border-bottom" id="detalleTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-dark rounded-0 border-0" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab">Resumen</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark rounded-0 border-0" id="evidencia-tab" data-bs-toggle="tab" data-bs-target="#evidencia" type="button" role="tab">Evidencias</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark rounded-0 border-0" id="bitacora-tab" data-bs-toggle="tab" data-bs-target="#bitacora" type="button" role="tab">Bitácora</button>
            </li>
        </ul>

        <!-- Contenido de las Pestañas -->
        <div class="tab-content p-4" id="detalleTabsContent">

            <!-- Tab: Resumen -->
            <div class="tab-pane fade show active" id="resumen" role="tabpanel" aria-labelledby="resumen-tab">
                <h6 class="text-muted text-uppercase fw-bold text-xs mb-2">Clasificación Inicial</h6>
                <p class="fs-5 fw-medium mb-4" id="lblTipo">Cargando...</p>

                <h6 class="text-muted text-uppercase fw-bold text-xs mb-2">Ubicación de los hechos</h6>
                <p class="mb-1"><i class="fa-solid fa-map-location-dot text-primary me-2"></i> <span id="lblDepto">...</span>, <span id="lblMuni">...</span></p>
                <p class="mb-4 text-muted small" id="lblDireccion">...</p>

                <h6 class="text-muted text-uppercase fw-bold text-xs mb-2">Descripción del Denunciante</h6>
                <div class="p-3 bg-light rounded border text-secondary" id="lblDescripcion" style="font-size: 0.9rem;">
                    ...
                </div>

                <!-- Botonera de Acción Rápida (Ej. para Inspector) -->
                <div class="mt-4 d-grid gap-2">
                    <button class="btn btn-primary"><i class="fa-solid fa-check-double me-2"></i>Aprobar para Tipificación</button>
                    <button class="btn btn-outline-danger"><i class="fa-solid fa-ban me-2"></i>Descartar por Falta de Mérito</button>
                </div>
            </div>

            <!-- Tab: Evidencias -->
            <div class="tab-pane fade" id="evidencia" role="tabpanel" aria-labelledby="evidencia-tab">
                <div class="alert alert-info text-sm py-2"><i class="fa-solid fa-circle-info me-2"></i> 2 archivos adjuntos.</div>

                <!-- Mockup de Galería -->
                <div class="card mb-3 shadow-sm">
                    <img src="https://via.placeholder.com/400x200?text=Foto+Evidencia+1" class="card-img-top" alt="Evidencia">
                    <div class="card-body py-2">
                        <small class="text-muted">valla_publicitaria.jpg (2.4 MB)</small>
                    </div>
                </div>
            </div>

            <!-- Tab: Bitácora (Timeline) -->
            <div class="tab-pane fade" id="bitacora" role="tabpanel" aria-labelledby="bitacora-tab">
                <div class="position-relative border-start border-2 border-primary ms-2 pb-4 ps-3">
                    <div class="position-absolute bg-primary rounded-circle" style="width: 12px; height: 12px; left: -7px; top: 0;"></div>
                    <small class="text-muted d-block fw-bold">Hoy, 10:45 AM</small>
                    <span class="d-block mt-1">Asignado al Inspector <strong>Julio Álvarez</strong></span>
                    <small class="text-primary">Por: Supervisor Autoasignación</small>
                </div>
                <div class="position-relative border-start border-2 border-light ms-2 pb-2 ps-3">
                    <div class="position-absolute bg-secondary rounded-circle" style="width: 12px; height: 12px; left: -7px; top: 0;"></div>
                    <small class="text-muted d-block fw-bold">Hoy, 08:30 AM</small>
                    <span class="d-block mt-1">Denuncia ingresada vía Web Ciudadana</span>
                    <small class="text-muted">Por: Anónimo (IP: 192.168.1.1)</small>
                </div>
            </div>

        </div>
    </div>
</div>