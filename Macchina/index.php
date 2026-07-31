<?php

/* * SISTEMA DE GESTIÓN DE DENUNCIAS ELECTORALES * Front Controller Entry Point */

// 1. Iniciar sesión segura (prevenir secuestro de sesión)
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 en producción con HTTPS
session_start();

// 2. Cargar dependencias core de configuración y base de datos
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'helpers/utils.php';

// 3. Cargar motor MVC
require_once 'core/Controller.php';
require_once 'core/Router.php';

// 4. Ejecutar la aplicación interceptando la URL
Router::run();
