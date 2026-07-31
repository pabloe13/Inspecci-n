<?php
// Validar acceso directo
if (!defined('APP_URL')) die('Acceso directo no permitido.');
?>

<header class="top-navbar">
    <!-- Botón Hamburguesa Móvil (Oculto en Desktop mediante Bootstrap d-lg-none) -->
    <button class="btn btn-link text-dark d-lg-none p-0 me-3 fs-4" id="sidebarToggle" aria-label="Abrir Menú">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Buscador Global -->
    <form class="navbar-search d-none d-md-flex align-items-center w-50">
        <div class="input-group">
            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
            <input type="text" class="form-control" placeholder="Buscar por código de expediente o DPI..." aria-label="Buscar expediente">
        </div>
    </form>

    <!-- Opciones de Usuario (SSO Mockup) -->
    <div class="d-flex align-items-center ms-auto">
        <!-- Notificaciones -->
        <div class="dropdown me-3">
            <button class="btn btn-link text-dark text-decoration-none position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-regular fa-bell fs-5"></i>
                <span class="position-absolute top-25 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">Nuevas alertas</span>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li>
                    <h6 class="dropdown-header">Notificaciones</h6>
                </li>
                <li><a class="dropdown-item" href="#">Nueva denuncia asignada (D-1029)</a></li>
                <li><a class="dropdown-item" href="#">Magistratura devolvió expediente</a></li>
            </ul>
        </div>

        <!-- Perfil Usuario -->
        <div class="dropdown">
            <button class="btn btn-light rounded-pill dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                    <strong>JA</strong> <!-- Iniciales -->
                </div>
                <span class="d-none d-md-inline text-dark small fw-medium">Julio Álvarez</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li>
                    <div class="dropdown-item-text">
                        <small class="text-muted d-block">Rol Actual</small>
                        <strong>Inspector de Campo</strong>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?= APP_URL ?>/perfil"><i class="fa-regular fa-user me-2"></i> Mi Perfil</a></li>
                <li><a class="dropdown-item text-danger" href="<?= APP_URL ?>/auth/logout"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</header>