<?php

/** * Controlador Base para manejar el renderizado de vistas y respuestas estándar. */
class Controller
{

    /*     * Renderizar una vista HTML empaquetándola con el layout principal.
     * 
     * @param string $viewName Ruta de la vista relativa a la carpeta /views (ej. 'dashboard/index')
     * @param array $data Arreglo asociativo con variables a pasar a la vista
     */
    protected function render($viewName, $data = [])
    {
        // Extrae el array asociativo a variables individuales ($data['nombre'] -> $nombre)
        if (!empty($data)) {
            extract($data);
        }

        $viewPath = ROOT_PATH . '/views/' . $viewName . '.php';

        if (file_exists($viewPath)) {
            // Cargar el Layout
            require_once ROOT_PATH . '/includes/header.php';

            // Cargar el contenido específico de la página
            require_once $viewPath;

            // Cargar el pie de página
            require_once ROOT_PATH . '/includes/footer.php';
        } else {
            // Manejo de error si el desarrollador olvida crear el archivo HTML
            error_log("Vista no encontrada: " . $viewPath);
            die("Error del Sistema: La vista solicitada no está disponible.");
        }
    }

    /*     * Wrapper rápido para responder JSON desde cualquier controlador (API requests)     */
    protected function responseJson($status, $message, $data = [], $statusCode = 200)
    {
        Utils::jsonResponse($status, $message, $data, $statusCode);
    }
}
