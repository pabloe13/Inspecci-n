<?php
class Utils
{

    /*     * Retorna una respuesta JSON estructurada y detiene la ejecución.     */
    public static function jsonResponse($status, $message, $data = [], $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    /*     * Sanitiza entradas de usuario recursivamente.     */
    public static function sanitize($input)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = self::sanitize($value);
            }
            return $input;
        }
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /*     * Genera un código de seguimiento ciudadano (Ej. D-20260730-A1B2C)     */
    public static function generateTrackingCode()
    {
        return 'D-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
    }
}
