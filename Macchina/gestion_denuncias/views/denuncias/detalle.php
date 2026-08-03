<?php

/** @var array|null $expediente Variable proveida por DenunciasController */
$expediente = $expediente ?? $_GET['expediente'] ?? $_POST['expediente'] ?? null;

if (!$expediente) {
    // Si no hay expediente cargado, redirigir o mostrar alerta
    header("Location: " . BASE_URL . "denuncias");
    exit;
}
?>

<div class="admin-layout">
    <?php require_once ROOT_PATH . '/includes/sidebar.php'; ?>

    <div class="main-wrapper">
        <?php require_once ROOT_PATH . '/includes/navbar.php'; ?>

        <main class="content-area">
            <div class="container-fluid p-4">

                <!-- Encabezado del Expediente -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a href="?url=denuncias/index" class="text-decoration-none text-muted small mb-2 d-block">
                            <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
                        </a>
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">
                            Expediente: <span class="text-primary"><?= htmlspecialchars($expediente['token_seguimiento']) ?></span>
                        </h1>
                        <p class="text-muted small mb-0">Registrada el: <?= htmlspecialchars($expediente['fecha_registro']) ?></p>
                    </div>
                    <div>
                        <span class="badge bg-primary fs-6 px-3 py-2"><?= htmlspecialchars($expediente['estado']) ?></span>
                        <button id="btnExportarPDF" class="btn btn-outline-danger ms-2" title="Exportar a PDF">
                            <i class="fa-solid fa-file-pdf me-2"></i> Generar PDF
                        </button>
                    </div>
                </div>

                <div class="row">
                    <!-- Contenedor que será transformado a PDF -->
                    <div id="documentoPdf" class="p-3 bg-white">

                        <!-- Agregamos un encabezado oficial que SÓLO se verá bien en el PDF -->
                        <div class="text-center mb-4 d-none d-print-block" id="headerOficial">
                            <h4 class="fw-bold">TRIBUNAL SUPREMO ELECTORAL</h4>
                            <h6 class="text-muted">Departamento de Inspección</h6>
                            <hr>
                        </div>
                        <div class="row">
                            <!-- Columna Izquierda: Los Hechos -->
                            <div class="col-lg-8 mb-4">
                                <div class="card shadow-sm border-0 mb-4">
                                    <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
                                        <h5 class="fw-bold text-dark"><i class="fa-solid fa-file-lines text-muted me-2"></i>Descripción de los Hechos</h5>
                                    </div>
                                    <div class="card-body">
                                        <span class="badge bg-light text-dark border mb-3"><?= htmlspecialchars($expediente['nombre_categoria']) ?></span>
                                        <p class="text-dark" style="white-space: pre-wrap; text-align: justify;">
                                            <?= htmlspecialchars($expediente['descripcion_hechos']) ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
                                        <h5 class="fw-bold text-dark"><i class="fa-solid fa-location-dot text-muted me-2"></i>Ubicación del Incidente</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p class="small text-muted mb-0">Departamento / Municipio</p>
                                                <p class="fw-bold mb-0"><?= htmlspecialchars($expediente['departamento']) ?> / <?= htmlspecialchars($expediente['municipio']) ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="small text-muted mb-0">Dirección Exacta</p>
                                                <p class="fw-bold mb-0"><?= htmlspecialchars($expediente['direccion_exacta']) ?></p>
                                            </div>
                                        </div>
                                        <!-- Contenedor del Mapa -->
                                        <div id="mapaDenuncia" style="height: 300px; border-radius: 8px; z-index: 1;"></div>

                                        <!-- Pasamos las variables a JS de forma segura -->
                                        <script>
                                            const latitudDenuncia = <?= json_encode($expediente['latitud']) ?>;
                                            const longitudDenuncia = <?= json_encode($expediente['longitud']) ?>;
                                        </script>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna Derecha: Denunciante y Acciones -->
                            <div class="col-lg-4">
                                <div class="card shadow-sm border-0 mb-4 border-top border-primary border-4">
                                    <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
                                        <h5 class="fw-bold text-dark"><i class="fa-solid fa-user-shield text-muted me-2"></i>Datos del Denunciante</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($expediente['es_anonimo'] == 1): ?>
                                            <div class="alert alert-secondary text-center">
                                                <i class="fa-solid fa-mask fs-3 mb-2 text-muted"></i>
                                                <p class="mb-0 fw-bold">Denuncia Anónima</p>
                                                <small>Por ley, la identidad está protegida.</small>
                                            </div>
                                        <?php else: ?>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0 py-2">
                                                    <small class="text-muted d-block">Nombre Completo</small>
                                                    <span class="fw-bold"><?= htmlspecialchars($expediente['nombres'] . ' ' . $expediente['apellidos']) ?></span>
                                                </li>
                                                <li class="list-group-item px-0 py-2">
                                                    <small class="text-muted d-block">DPI</small>
                                                    <span class="fw-bold"><?= htmlspecialchars($expediente['dpi'] ?: 'No proporcionado') ?></span>
                                                </li>
                                                <li class="list-group-item px-0 py-2">
                                                    <small class="text-muted d-block">Teléfono</small>
                                                    <span class="fw-bold"><?= htmlspecialchars($expediente['telefono'] ?: 'No proporcionado') ?></span>
                                                </li>
                                                <li class="list-group-item px-0 py-2">
                                                    <small class="text-muted d-block">Correo Electrónico</small>
                                                    <span class="fw-bold"><?= htmlspecialchars($expediente['email'] ?: 'No proporcionado') ?></span>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Panel de Acciones Internas -->
                                <div class="card shadow-sm border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Acciones de Inspección</h6>
                                        <button class="btn btn-primary w-100 mb-2">
                                            <i class="fa-solid fa-pen-to-square me-2"></i> Actualizar Estado
                                        </button>
                                        <button class="btn btn-outline-dark w-100">
                                            <i class="fa-solid fa-paperclip me-2"></i> Adjuntar Documento
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
        </main>
    </div>
</div>