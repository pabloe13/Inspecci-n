<?php if (!defined('APP_URL')) die('Acceso directo no permitido.'); ?>

<div class="admin-layout">
    <?php require_once ROOT_PATH . '/includes/sidebar.php'; ?>

    <div class="main-wrapper">
        <?php require_once ROOT_PATH . '/includes/navbar.php'; ?>

        <main class="content-area">
            <div class="container-fluid p-0 h-100 d-flex flex-column">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Solicitudes de Oficio</h1>
                        <p class="text-muted small mb-0">Expedientes generados directamente por inspectores colaboradores en campo.</p>
                    </div>
                    <a href="<?= APP_URL ?>/solicitudes/crear" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Nueva Solicitud de Oficio
                    </a>
                </div>

                <!-- Contenedor del DataGrid DevExtreme -->
                <div class="card shadow-sm border-0 flex-grow-1">
                    <div class="card-body p-0">
                        <div id="gridSolicitudes" style="height: calc(100vh - 195px);"></div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>