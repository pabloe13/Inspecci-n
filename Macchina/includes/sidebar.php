<?php
// Validar acceso directo
if (!defined('APP_URL')) die('Acceso directo no permitido.');

// Determinar el módulo actual para marcar la opción activa
$module = isset($currentModule) ? $currentModule : '';
?>

<!-- Overlay para oscurecer el fondo en móviles al abrir el menú -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Navegación Lateral -->
<aside class="sidebar" id="sidebar">
    <a href="<?= APP_URL ?>/dashboard" class="sidebar-brand">
        <i class="fa-solid fa-scale-balanced me-2"></i> TSE GESTIÓN
    </a>

    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="<?= APP_URL ?>/dashboard" class="sidebar-link <?= ($module === 'dashboard') ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>

        <!-- Denuncias Ciudadanas -->
        <a href="<?= APP_URL ?>/denuncias" class="sidebar-link <?= ($module === 'denuncias') ? 'active' : '' ?>">
            <i class="fa-solid fa-inbox"></i> Denuncias <span class="badge text-bg-danger ms-auto rounded-pill">3</span>
        </a>

        <!-- Solicitudes de Inspectores -->
        <a href="<?= APP_URL ?>/solicitudes" class="sidebar-link <?= ($module === 'solicitudes') ? 'active' : '' ?>">
            <i class="fa-solid fa-file-signature"></i> Solicitudes
        </a>

        <!-- Reportes -->
        <a href="<?= APP_URL ?>/reportes" class="sidebar-link <?= ($module === 'reportes') ? 'active' : '' ?>">
            <i class="fa-solid fa-file-export"></i> Reportes
        </a>

        <!-- Configuración (Solo Administradores, validación que haremos en backend después) -->
        <a href="<?= APP_URL ?>/configuracion" class="sidebar-link <?= ($module === 'configuracion') ? 'active' : '' ?>">
            <i class="fa-solid fa-sliders"></i> Configuración
        </a>
    </nav>
</aside>