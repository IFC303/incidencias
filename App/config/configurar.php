<?php
// Ruta de la aplicacion
define('RUTA_APP', dirname(dirname(__FILE__)));

// Ruta url, Ejemplo: http://localhost/daw2_mvc
define('RUTA_URL', "http://{$_SERVER['HTTP_HOST']}/incidencias");

define('NOMBRE_SITIO', 'Incidencias');

// Configuracion de la Base de Datos
define('DB_HOST', $_SERVER['HTTP_HOST'] == 'localhost' ? 'localhost' : 'mysql');
define('DB_USUARIO', 'root');
define('DB_PASSWORD', 'toor');
define('DB_NOMBRE', 'incidencias');
