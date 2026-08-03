/**
 * Script Específico de la Intranet (Admin)
 * Maneja el comportamiento del layout SPA y utilidades de la interfaz interna.
 */
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    // Función para abrir/cerrar menú en móviles
    const toggleSidebar = () => {
        if (sidebar && overlay) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    };

    // Asignar eventos de forma limpia
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    // Cerrar el menú si se hace clic afuera (en el overlay oscuro)
    if (overlay) {
        overlay.addEventListener('click', toggleSidebar);
    }

    // Cerrar el menú automáticamente al cambiar de tamaño la pantalla a desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992 && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }
    });
});