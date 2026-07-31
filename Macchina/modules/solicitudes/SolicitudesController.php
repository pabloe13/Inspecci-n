<?php

/* * Controlador de Solicitudes * Gestiona el listado y creación de solicitudes de oficio por inspectores. */
class SolicitudesController extends Controller
{

    public function index()
    {
        $data = [
            'pageTitle' => 'Solicitudes de Oficio (Inspectores)',
            'currentModule' => 'solicitudes', // Ilumina la opción en el sidebar
            'extraCss' => [
                APP_URL . '/assets/css/admin.css?v=' . APP_VERSION,
                'https://cdn3.devexpress.com/jslib/23.2.3/css/dx.light.css'
            ],
            'extraJs' => [
                APP_URL . '/assets/js/admin.js?v=' . APP_VERSION,
                'https://cdn3.devexpress.com/jslib/23.2.3/js/dx.all.js',
                APP_URL . '/assets/js/modules/solicitudes.js?v=' . APP_VERSION
            ]
        ];

        $this->render('solicitudes/index', $data);
    }
}
