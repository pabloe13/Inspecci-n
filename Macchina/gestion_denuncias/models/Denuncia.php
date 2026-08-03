<?php
require_once ROOT_PATH . '/core/Conexion.php';

class Denuncia
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getInstance()->getPdo();
    }

    /*     * Obtiene el detalle completo de una sola denuncia por su ID     */
    public function obtenerPorId($id)
    {
        $query = "SELECT 
                d.ID_DENUNCIA as id_denuncia, 
                dt.TOKENSEGUIMIENTO as token_seguimiento, 
                dt.ESANONIMO as es_anonimo,
                c.NOMBRECATEGORIA as nombre_categoria, 
                vd.DESCRIPCION as departamento, 
                vm.DESCRIPCION as municipio,
                d.DIRECCION_EXACTA as direccion_exacta, 
                d.LATITUD as latitud, 
                d.LONGITUD as longitud,
                d.DESCRIPCION_HECHOS as descripcion_hechos, 
                d.ESTADO as estado, 
                d.FECREGISTRO as fecha_registro,
                d.FECINCIDENTE as fecha_incidente,
                dt.NOMBRES as nombres, 
                dt.APELLIDOS as apellidos, 
                dt.DPI as dpi, 
                dt.EMAIL as email, 
                dt.TELEFONO as telefono
            FROM DENUNCIAS.TDENUNCIAS d
            INNER JOIN DENUNCIAS.TDENUNCIANTES dt ON d.ID_DENUNCIANTE = dt.ID_DENUNCIANTE
            LEFT JOIN DENUNCIAS.TCATDENUNCIA c ON d.ID_CATEGORIA = c.ID_CATEGORIA
            LEFT JOIN DENUNCIAS.V_DEPARTAMENTOS vd ON d.CODDEP = vd.CODDEP
            LEFT JOIN DENUNCIAS.V_MUNICIPIOS vm ON d.CODDEP = vm.CODDEP AND d.CODMUN = vm.CODMUN
            WHERE d.ID_DENUNCIA = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $row['latitud'] = (float)$row['latitud'];
            $row['longitud'] = (float)$row['longitud'];
            $row['estado'] = !empty($row['estado']) ? $row['estado'] : 'NUEVA';
        }

        return $row;
    }

    /*     * Obtiene todas las denuncias con sus joins     */
    public function listarTodas()
    {
        // Usamos exactamente tu query adaptada
        $query = "SELECT 
                d.ID_DENUNCIA as id_denuncia, 
                dt.TOKENSEGUIMIENTO as token_seguimiento, 
                dt.ESANONIMO as es_anonimo,
                c.NOMBRECATEGORIA as nombre_categoria, 
                vd.DESCRIPCION as departamento, 
                vm.DESCRIPCION as municipio,
                d.DIRECCION_EXACTA as direccion_exacta, 
                d.LATITUD as latitud, 
                d.LONGITUD as longitud,
                d.DESCRIPCION_HECHOS as descripcion_hechos, 
                d.ESTADO as estado, 
                d.FECREGISTRO as fecha_registro,
                dt.NOMBRES as nombres, 
                dt.APELLIDOS as apellidos, 
                dt.DPI as dpi, 
                dt.EMAIL as email, 
                dt.TELEFONO as telefono
            FROM DENUNCIAS.TDENUNCIAS d
            INNER JOIN DENUNCIAS.TDENUNCIANTES dt ON d.ID_DENUNCIANTE = dt.ID_DENUNCIANTE
            LEFT JOIN DENUNCIAS.TCATDENUNCIA c ON d.ID_CATEGORIA = c.ID_CATEGORIA
            LEFT JOIN DENUNCIAS.V_DEPARTAMENTOS vd ON d.CODDEP = vd.CODDEP
            LEFT JOIN DENUNCIAS.V_MUNICIPIOS vm ON d.CODDEP = vm.CODDEP AND d.CODMUN = vm.CODMUN
            ORDER BY d.FECREGISTRO DESC";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $denuncias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Asegurar parseo a float para mapas y DevExtreme
            $row['latitud'] = (float)$row['latitud'];
            $row['longitud'] = (float)$row['longitud'];
            $row['estado'] = !empty($row['estado']) ? $row['estado'] : 'NUEVA';

            $denuncias[] = $row;
        }

        return $denuncias;
    }

    /*     * Actualiza el estado de la denuncia     */
    public function actualizarEstado($id_denuncia, $nuevo_estado)
    {
        $stmt = $this->pdo->prepare("UPDATE DENUNCIAS.TDENUNCIAS SET ESTADO = ? WHERE ID_DENUNCIA = ?");
        return $stmt->execute([$nuevo_estado, $id_denuncia]);
    }
}
