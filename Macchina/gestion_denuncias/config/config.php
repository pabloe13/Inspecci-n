<?php
// config/config.php

// Detección automática de la URL base
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host     = $_SERVER['HTTP_HOST'];
$script   = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl  = rtrim($protocol . $host . $script, '/') . '/';

define('BASE_URL', 'http://localhost/Macchina/gestion_denuncias/');
define('APP_NAME', 'Sistema de Gestión Interna - TSE');
define('APP_VERSION', '1.0.0');

// URL Base (CORREGIDA PARA APUNTAR A LA RAÍZ DEL PROYECTO)
define('APP_URL', 'http://localhost/Macchina/gestion_denuncias');

// Rutas absolutas del servidor
define('ROOT_PATH', dirname(__DIR__));
define('ASSETS_PATH', APP_URL . '/assets');
define('UPLOAD_PATH', ROOT_PATH . '/uploads');

// Configuración de la Base de Datos Oracle
define('DB_HOST', '192.168.25.7');
define('DB_PORT', '1522');
define('DB_NAME', 'NEWDESA');
define('DB_USER', 'DENUNCIAS');
define('DB_PASS', 'm9wn3kW7N');
define('DB_CHARSET', 'AL32UTF8');

// Configuración de zona horaria (Guatemala)
date_default_timezone_set('America/Guatemala');
