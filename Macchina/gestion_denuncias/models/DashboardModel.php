<?php
require_once ROOT_PATH . '/core/Conexion.php';

class DashboardModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getInstance()->getPdo();
    }

    /*     * Obtiene los conteos generales (KPIs)     */
    public function getKPIs()
    {
        $query = "SELECT 
                    COUNT(ID_DENUNCIA) AS TOTAL,
                    NVL(SUM(CASE WHEN ESTADO = 'NUEVA' OR ESTADO IS NULL THEN 1 ELSE 0 END), 0) AS NUEVAS,
                    NVL(SUM(CASE WHEN ESTADO = 'EN PROCESO' THEN 1 ELSE 0 END), 0) AS EN_PROCESO,
                    NVL(SUM(CASE WHEN ESTADO = 'RESUELTA' OR ESTADO = 'TIPIFICADA' THEN 1 ELSE 0 END), 0) AS RESUELTAS
                    FROM DENUNCIAS.TDENUNCIAS";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*     * Obtiene denuncias agrupadas por categoría para la gráfica de dona     */
    public function getDenunciasPorCategoria()
    {
        $query = "SELECT 
                    NVL(c.NOMBRECATEGORIA, 'Sin Categoría') AS CATEGORIA, 
                    COUNT(d.ID_DENUNCIA) AS TOTAL 
                    FROM DENUNCIAS.TDENUNCIAS d
                    LEFT JOIN DENUNCIAS.TCATDENUNCIA c ON d.ID_CATEGORIA = c.ID_CATEGORIA
                    GROUP BY c.NOMBRECATEGORIA
                    ORDER BY TOTAL DESC";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*     * Obtiene la tendencia de denuncias por mes (Año actual) para la gráfica de barras     */
    public function getTendenciaMensual()
    {
        $query = "SELECT 
                    TO_CHAR(FECREGISTRO, 'MM') AS MES, 
                    COUNT(ID_DENUNCIA) AS TOTAL 
                    FROM DENUNCIAS.TDENUNCIAS 
                    WHERE TO_CHAR(FECREGISTRO, 'YYYY') = TO_CHAR(SYSDATE, 'YYYY')
                    GROUP BY TO_CHAR(FECREGISTRO, 'MM')
                    ORDER BY MES ASC";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
