<?php
require_once ROOT_PATH . '/models/Denuncia.php';
/* * Controlador de Denuncias * Gestiona la bandeja principal y el detalle de los expedientes. */
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
    public function api_listar()
    {
        header('Content-Type: application/json; charset=UTF-8');
        try {
            $modelo = new Denuncia();
            $datos = $modelo->listarTodas();
            echo json_encode($datos);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
        }
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

    public function api_actualizar_estado()
    {
        header('Content-Type: application/json; charset=UTF-8');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Decodificamos el JSON que enviará JS
            $data = json_decode(file_get_contents("php://input"));

            if (!empty($data->id_denuncia) && !empty($data->nuevo_estado)) {
                try {
                    $modelo = new Denuncia();
                    $modelo->actualizarEstado($data->id_denuncia, $data->nuevo_estado);
                    echo json_encode(["status" => "success", "mensaje" => "Expediente actualizado a " . $data->nuevo_estado]);
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["status" => "error", "mensaje" => "Faltan datos requeridos."]);
            }
        }
    }

    public function detalle($id = null)
    {
        if (!$id) {
            header('Location: ' . APP_URL . '/?url=denuncias/index');
            exit();
        }

        $modelo = new Denuncia();
        $expediente = $modelo->obtenerPorId($id);

        if (!$expediente) {
            die("Expediente no encontrado.");
        }

        $data = [
            'pageTitle' => 'Expediente: ' . $expediente['token_seguimiento'],
            'currentModule' => 'denuncias',
            'expediente' => $expediente,
            'extraCss' => [
                APP_URL . '/assets/css/admin.css?v=' . APP_VERSION,
                'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'
            ],
            'extraJs' => [
                APP_URL . '/assets/js/admin.js?v=' . APP_VERSION,
                'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
                // --- NUEVA LIBRERÍA AÑADIDA PARA PDF ---
                'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js',
                APP_URL . '/assets/js/modules/detalle_denuncia.js?v=' . APP_VERSION
            ]
        ];

        $this->render('denuncias/detalle', $data);
    }
}
