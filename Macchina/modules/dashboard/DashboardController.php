<?php

/* * Controlador del Dashboard * Gestiona la pantalla principal de la Intranet. */

class DashboardController extends Controller
{

    public function index()
    {
        // En una etapa posterior, esto vendrá de una clase Model (Ej. DashboardModel::getKPIs())
        $kpis = [
            'nuevas' => 14,
            'en_proceso' => 45,
            'aprobadas' => 89,
            'rechazadas' => 12,
            'asignadas' => 40,
            'sin_asignar' => 5
        ];

        // Actividades recientes simuladas
        $actividades = [
            ['hora' => '10:30 AM', 'usuario' => 'Julio Álvarez', 'accion' => 'Tipificó el expediente D-20260730-A1B2C', 'tipo' => 'success'],
            ['hora' => '09:45 AM', 'usuario' => 'Sistema', 'accion' => 'Ingresó nueva denuncia ciudadana desde Huehuetenango', 'tipo' => 'primary'],
            ['hora' => '08:15 AM', 'usuario' => 'María López', 'accion' => 'Descartó denuncia D-20260729-XXY99 (Falta de mérito)', 'tipo' => 'danger']
        ];

        // Definimos la data que enviaremos a la vista
        $data = [
            'pageTitle' => 'Dashboard Ejecutivo',
            'currentModule' => 'dashboard', // Para el Sidebar
            'kpis' => $kpis,
            'actividades' => $actividades,

            // Inyectamos CSS específico para esta vista (DevExtreme y layout admin)
            'extraCss' => [
                APP_URL . '/assets/css/admin.css?v=' . APP_VERSION,
                'https://cdn3.devexpress.com/jslib/23.2.3/css/dx.light.css'
            ],

            // Inyectamos JS específico para esta vista (Admin UI, DevExtreme y lógica del dashboard)
            'extraJs' => [
                APP_URL . '/assets/js/admin.js?v=' . APP_VERSION,
                'https://cdn3.devexpress.com/jslib/23.2.3/js/dx.all.js',
                APP_URL . '/assets/js/modules/dashboard.js?v=' . APP_VERSION
            ]
        ];

        // Renderizamos la vista correspondiente, pasando el arreglo de datos
        $this->render('dashboard/index', $data);
    }
}
