/* * Core de Javascript - Sistema de Denuncias  */
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // Namespace global para utilidades de la aplicación
    window.App = {
        
        /**
         * Wrapper para peticiones Fetch (AJAX)
         * Maneja automáticamente JSON, cabeceras y errores comunes.
         * 
         * @param {string} url - Ruta de la API
         * @param {object} options - Opciones (method, body, etc.)
         * @returns {Promise}
         */
        fetchAPI: async function(url, options = {}) {
            // Configuración por defecto
            const defaultOptions = {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Para que PHP detecte que es AJAX
                }
            };

            // Mezclar opciones por defecto con las enviadas
            const finalOptions = { ...defaultOptions, ...options };

            // Si se envía FormData (ej. subida de archivos), el navegador debe establecer el Content-Type automáticamente
            if (options.body && options.body instanceof FormData) {
                delete finalOptions.headers['Content-Type'];
            } else if (options.body && typeof options.body === 'object') {
                finalOptions.body = JSON.stringify(options.body);
            }

            try {
                const response = await fetch(url, finalOptions);
                
                // Intentar parsear a JSON si la respuesta lo es
                const contentType = response.headers.get("content-type");
                let data = null;
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    data = await response.json();
                } else {
                    data = await response.text();
                }

                if (!response.ok) {
                    throw new Error(data.message || `Error HTTP: ${response.status}`);
                }

                return data;

            } catch (error) {
                console.error('[App.fetchAPI] Error:', error);
                // Aquí podríamos integrar un Toast global de error en el futuro
                throw error; 
            }
        },

        /*         * Inicializa tooltips de Bootstrap en toda la app    */
        initTooltips: function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    };

    // Inicializaciones globales
    App.initTooltips();
});