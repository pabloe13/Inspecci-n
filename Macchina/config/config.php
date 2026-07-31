<?php
// Configuración general de la aplicación
define('APP_NAME', 'Sistema de Gestión de Denuncias Electorales');
define('APP_VERSION', '1.0.0');

// URL Base (Ajustar)
define('APP_URL', 'http://localhost/Macchina');

// Rutas absolutas del servidor (Evita problemas con require/include en diferentes niveles)
define('ROOT_PATH', dirname(__DIR__));
define('ASSETS_PATH', APP_URL . '/assets');
define('UPLOAD_PATH', ROOT_PATH . '/uploads');

// Configuración de la Base de Datos Oracle
define('DB_HOST', 'localhost');
define('DB_PORT', '1521');
define('DB_NAME', 'TSEDB'); // Cambiar por tu SID o Service Name de Oracle
define('DB_USER', 'TSE_ADMIN'); // Ajustar usuario
define('DB_PASS', 'Tse_Admin_2026'); // Ajustar contraseña
define('DB_CHARSET', 'AL32UTF8');

// Configuración de zona horaria (Guatemala)
date_default_timezone_set('America/Guatemala');
