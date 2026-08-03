<?php
/* * Enrutador Dinámico (Front Controller Dispatcher) */
class Router
{

    public static function run()
    {
        // 1. Obtener la URL, sanitizarla y quitar las barras finales. 
        // Si no existe o está vacía, cargar por defecto el módulo 'dashboard'
        $url = (isset($_GET['url']) && $_GET['url'] !== '') ? rtrim($_GET['url'], '/') : 'dashboard/index';
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $urlParts = explode('/', $url);

        // 2. Extraer Componentes MVC de la URL
        $moduleName = strtolower($urlParts[0]);
        // Convierte 'dashboard' en 'DashboardController'
        $controllerName = ucfirst($moduleName) . 'Controller';
        // Si no hay acción especificada, por defecto ejecuta 'index'
        $actionName = isset($urlParts[1]) && $urlParts[1] != '' ? strtolower($urlParts[1]) : 'index';
        // Todos los parámetros extra que vengan en la URL (ej. ID del expediente)
        $params = array_slice($urlParts, 2);

        // 3. Buscar el archivo del controlador
        $controllerFile = ROOT_PATH . '/modules/' . $moduleName . '/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            if (class_exists($controllerName)) {
                // Instanciar el controlador (ej. new DashboardController())
                $controller = new $controllerName();

                if (method_exists($controller, $actionName)) {
                    // Ejecutar el método pasando los parámetros de forma dinámica
                    call_user_func_array([$controller, $actionName], $params);
                } else {
                    self::show404("La acción '$actionName' no es válida en el módulo '$moduleName'.");
                }
            } else {
                self::show404("La clase '$controllerName' no fue declarada correctamente.");
            }
        } else {
            self::show404("El módulo '$moduleName' no existe.");
        }
    }

    /**
     * Muestra una página de Error 404
     */
    private static function show404($devMessage = "")
    {
        http_response_code(404);

        // Aquí podríamos cargar una vista /views/error/404.php en un entorno real.
        // Por ahora, enviamos HTML directo usando el header y footer base.
        require_once ROOT_PATH . '/includes/header.php';
        echo '<div class="container mt-5 text-center">';
        echo '<h1 class="display-1 text-danger"><i class="fa-solid fa-triangle-exclamation"></i> 404</h1>';
        echo '<h2>Página no encontrada</h2>';
        echo '<p class="lead">El recurso que está buscando no existe o ha sido movido.</p>';
        echo '<a href="' . APP_URL . '" class="btn btn-primary">Volver al Inicio</a>';
        echo '</div>';
        require_once ROOT_PATH . '/includes/footer.php';
        exit;
    }
}
