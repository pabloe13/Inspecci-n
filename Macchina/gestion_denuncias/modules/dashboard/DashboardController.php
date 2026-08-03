<?php
require_once ROOT_PATH . '/models/DashboardModel.php';

class DashboardController extends Controller
{

    public function index()
    {
        // Instanciamos el modelo y traemos los KPIs para pintarlos de inmediato en el HTML
        $modelo = new DashboardModel();

        try {
            $kpis = $modelo->getKPIs();
        } catch (Exception $e) {
            // Valores por defecto si falla la BD
            $kpis = ['total' => 0, 'nuevas' => 0, 'en_proceso' => 0, 'resueltas' => 0];
        }

        $data = [
            'pageTitle' => 'Dashboard | Portal de Denuncias',
            'currentModule' => 'dashboard',
            'kpis' => $kpis, // Pasamos los datos a la vista
            'actividades' => [],
            'extraCss' => [APP_URL . '/assets/css/admin.css?v=' . APP_VERSION],
            'extraJs' => [
                'https://cdn.jsdelivr.net/npm/apexcharts',
                APP_URL . '/assets/js/admin.js?v=' . APP_VERSION,
                APP_URL . '/assets/js/modules/dashboard.js?v=' . APP_VERSION
            ]
        ];

        $this->render('dashboard/index', $data);
    }

    // Endpoint API para las gráficas
    public function api_graficas()
    {
        header('Content-Type: application/json; charset=UTF-8');
        try {
            $modelo = new DashboardModel();

            $categorias = $modelo->getDenunciasPorCategoria();
            $mensual = $modelo->getTendenciaMensual();

            echo json_encode([
                "status" => "success",
                "categorias" => $categorias,
                "mensual" => $mensual
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
        }
    }
}
