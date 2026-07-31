<?php

/**
 * Controlador de Denuncias
 * Gestiona la bandeja principal y el detalle de los expedientes.
 */
class DenunciasController extends Controller
{

    public function index()
    {
        // Data para inyectar en la vista
        $data = [
            'pageTitle' => 'Gestión de Denuncias Ciudadanas',
            'currentModule' => 'denuncias', // Ilumina el menú lateral

            // Inyectamos CSS (Bootstrap Icons extra para timeline, DevExtreme base)
            'extraCss' => [
                APP_URL . '/assets/css/admin.css?v=' . APP_VERSION,
                'https://cdn3.devexpress.com/jslib/23.2.3/css/dx.light.css'
            ],

            // Inyectamos JS (Script de DevExtreme sin jQuery, y nuestra lógica local)
            'extraJs' => [
                APP_URL . '/assets/js/admin.js?v=' . APP_VERSION,
                'https://cdn3.devexpress.com/jslib/23.2.3/js/dx.all.js',
                APP_URL . '/assets/js/modules/denuncias.js?v=' . APP_VERSION
            ]
        ];

        $this->render('denuncias/index', $data);
    }
    public function crear()
    {
        $data = [
            'pageTitle' => 'Ingreso Manual de Denuncia',
            'currentModule' => 'denuncias', // Mantiene iluminado el menú
            'extraCss' => [
                APP_URL . '/assets/css/admin.css?v=' . APP_VERSION
            ],
            'extraJs' => [
                APP_URL . '/assets/js/modules/denuncia_crear.js?v=' . APP_VERSION
            ]
        ];

        $this->render('denuncias/crear', $data);
    }
}
