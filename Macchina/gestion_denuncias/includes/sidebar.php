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
        <i class="fa-solid fa-scale-balanced me-2"></i> GESTIÓN DE DENUNCIAS Y SOLICITUDES</a>

    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="<?= APP_URL ?>/dashboard" class="sidebar-link <?= ($module === 'dashboard') ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-pie"></i> Dashboard</a>

        <!-- Denuncias Ciudadanas -->
        <a href="<?= APP_URL ?>/denuncias" class="sidebar-link <?= ($module === 'denuncias') ? 'active' : '' ?>">
            <i class="fa-solid fa-inbox"></i> Denuncias Ciudadanas <span id="denunciasCountBadge" class="badge text-bg-danger ms-auto rounded-pill"></span>
        </a>

        <!-- Solicitudes de Inspectores -->
        <a href="<?= APP_URL ?>/solicitudes" class="sidebar-link <?= ($module === 'solicitudes') ? 'active' : '' ?>">
            <i class="fa-solid fa-file-signature"></i> Solicitudes de Inspectores <span id="solicitudesCountBadge" class="badge text-bg-danger ms-auto rounded-pill"></span></a>

        <!-- Reportes -->
        <a href="<?= APP_URL ?>/reportes" class="sidebar-link <?= ($module === 'reportes') ? 'active' : '' ?>">
            <i class="fa-solid fa-file-export"></i> Reportes
        </a>
    </nav>
</aside>