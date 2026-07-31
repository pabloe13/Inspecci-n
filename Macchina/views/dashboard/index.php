<?php if (!defined('APP_URL')) die('Acceso directo no permitido.'); ?>

<div class="admin-layout">
    <!-- Incluir Menú Lateral -->
    <?php require_once ROOT_PATH . '/includes/sidebar.php'; ?>

    <div class="main-wrapper">
        <!-- Incluir Barra Superior -->
        <?php require_once ROOT_PATH . '/includes/navbar.php'; ?>

        <!-- Área de Contenido Dinámico -->
        <main class="content-area">
            <div class="container-fluid p-0">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Ejecutivo</h1>
                    <button class="btn btn-primary btn-sm shadow-sm">
                        <i class="fa-solid fa-download fa-sm text-white-50"></i> Generar Reporte
                    </button>
                </div>

                <!-- Fila de KPIs -->
                <div class="row g-3 mb-4">
                    <!-- Tarjeta: Nuevas -->
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card h-100 border-0 shadow-sm border-start border-danger border-4">
                            <div class="card-body p-3">
                                <div class="text-xs fw-bold text-danger text-uppercase mb-1">Nuevas</div>
                                <div class="h3 mb-0 fw-bold text-dark"><?= htmlspecialchars($kpis['nuevas']) ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta: Sin Asignar -->
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card h-100 border-0 shadow-sm border-start border-warning border-4">
                            <div class="card-body p-3">
                                <div class="text-xs fw-bold text-warning text-uppercase mb-1">Sin Asignar</div>
                                <div class="h3 mb-0 fw-bold text-dark"><?= htmlspecialchars($kpis['sin_asignar']) ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta: Asignadas -->
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card h-100 border-0 shadow-sm border-start border-info border-4">
                            <div class="card-body p-3">
                                <div class="text-xs fw-bold text-info text-uppercase mb-1">Asignadas</div>
                                <div class="h3 mb-0 fw-bold text-dark"><?= htmlspecialchars($kpis['asignadas']) ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta: En Proceso -->
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card h-100 border-0 shadow-sm border-start border-primary border-4">
                            <div class="card-body p-3">
                                <div class="text-xs fw-bold text-primary text-uppercase mb-1">En Proceso</div>
                                <div class="h3 mb-0 fw-bold text-dark"><?= htmlspecialchars($kpis['en_proceso']) ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta: Aprobadas/Resueltas -->
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card h-100 border-0 shadow-sm border-start border-success border-4">
                            <div class="card-body p-3">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Aprobadas</div>
                                <div class="h3 mb-0 fw-bold text-dark"><?= htmlspecialchars($kpis['aprobadas']) ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta: Rechazadas -->
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card h-100 border-0 shadow-sm border-start border-secondary border-4">
                            <div class="card-body p-3">
                                <div class="text-xs fw-bold text-secondary text-uppercase mb-1">Rechazadas</div>
                                <div class="h3 mb-0 fw-bold text-dark"><?= htmlspecialchars($kpis['rechazadas']) ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fila de Gráficas -->
                <div class="row mb-4 g-4">
                    <!-- Gráfica de Tendencia (Line Chart) -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <h6 class="m-0 fw-bold text-primary">Volumen de Denuncias (Últimos 7 días)</h6>
                            </div>
                            <div class="card-body">
                                <!-- Contenedor para DevExtreme Chart -->
                                <div id="chartTendencia" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfica de Distribución (Doughnut Chart) -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <h6 class="m-0 fw-bold text-primary">Top Anomalías</h6>
                            </div>
                            <div class="card-body">
                                <!-- Contenedor para DevExtreme PieChart -->
                                <div id="chartAnomalias" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fila de Actividad Reciente -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom pt-3 pb-3">
                                <h6 class="m-0 fw-bold text-dark">Actividad Reciente en el Sistema</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <?php foreach ($actividades as $act): ?>
                                        <div class="list-group-item px-4 py-3 d-flex align-items-center">
                                            <div class="me-3 text-<?= $act['tipo'] ?>">
                                                <i class="fa-solid fa-circle-dot fs-6"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 text-dark fw-medium"><?= htmlspecialchars($act['accion']) ?></h6>
                                                <small class="text-muted"><i class="fa-regular fa-clock me-1"></i><?= htmlspecialchars($act['hora']) ?> &middot; <?= htmlspecialchars($act['usuario']) ?></small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- Fin Container -->
        </main>
    </div>
</div>