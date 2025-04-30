<?php namespace Config;

// Crea una nueva instancia de nuestra clase RouteCollection.
$routes = Services::routes();

// Carga primero el archivo de rutas del sistema, para que la aplicación y el entorno
// puedan sobrescribirlo si es necesario.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Configuración del enrutador
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');  // Espacio de nombres por defecto para los controladores
$routes->setDefaultController('Home');            // Controlador por defecto
$routes->setDefaultMethod('index');               // Método por defecto
$routes->setTranslateURIDashes(false);            // No traducir guiones a guiones bajos
$routes->set404Override();                        // Manejador personalizado para errores 404 (si se configura)
//$routes->setAutoRoute(false);                   // Desactivar el enrutamiento automático (comentado)

/**
 * --------------------------------------------------------------------
 * Definición de rutas
 * --------------------------------------------------------------------
 */

// Obtenemos un aumento de rendimiento al especificar la ruta por defecto
// ya que no es necesario escanear directorios.
$routes->get('/', 'Home::index');
$routes->get('principal', 'Home::index');
$routes->get('quienes_somos', 'Home::quienes_somos');
$routes->get('Contacto', 'Home::Contacto'); // "Home" en mayúscula
$routes->get('Comercializacion', 'home::Comercializacion'); // "home" en minúscula
$routes->get('termino_usos', 'home::termino_usos');
$routes->get('footer', 'home::footer');

/**
 * --------------------------------------------------------------------
 * Rutas adicionales
 * --------------------------------------------------------------------
 *
 * A menudo necesitarás rutas adicionales y
 * querrás que puedan sobrescribir cualquier valor por defecto en este archivo.
 * Las rutas basadas en entorno son un ejemplo de ello. Usa require() para cargar archivos adicionales aquí.
 *
 * Tendrás acceso al objeto $routes dentro de ese archivo sin necesidad de volver a cargarlo.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
