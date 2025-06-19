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
$routes->get('Contacto', 'Home::Contacto'); 
$routes->get('Comercializacion', 'home::Comercializacion'); 
$routes->get('termino_usos', 'home::termino_usos');
$routes->get('footer', 'home::footer');
$routes->get('catalogo', 'Home::Catalogo');


// Rutas CRUD para usuarios 
$routes->get('usuarios', 'UserController::index'); // Listar todos (incluyendo desactivados)
$routes->get('usuarios/activos', 'UserController::activos'); // Listar solo activos
$routes->get('usuarios/(:num)', 'UserController::show/$1'); // Ver uno (incluyendo desactivados)
$routes->post('usuarios/crear', 'UserController::crear'); // Crear
$routes->put('usuarios/editar/(:num)', 'UserController::update/$1'); // Actualizar
$routes->delete('usuarios/eliminar/(:num)', 'UserController::delete/$1'); // Eliminación lógica
$routes->put('usuarios/restaurar/(:num)', 'UserController::restaurar/$1'); // Restaurar usuario
$routes->post('usuarios/crearAdmin', 'UserController::crearAdmin'); // Crear
// CRUD de Productos
$routes->get('productos', 'ProductoController::index'); // Listar todos
$routes->post('admin/panel/crear', 'ProductoController::crear'); // Crear producto
$routes->get('productos/editar/(:num)', 'ProductoController::editarView/$1'); // Vista de edición
$routes->put('productos/editar/(:num)', 'ProductoController::editar/$1'); // Procesar edición (PUT)
$routes->delete('productos/eliminar/(:num)', 'ProductoController::eliminar/$1');
$routes->get('productos', 'ProductoController::index');

/*
// Grupo de rutas para el carrito (protegidas por autenticación)
$routes->group('carrito', ['filter' => 'auth'], function($routes) {
    $routes->get('usuario/(:num)', 'CarritoController::obtenerCarrito/$1');
    $routes->post('agregar', 'CarritoController::agregar');
    $routes->put('actualizar/(:num)', 'CarritoController::editarProducto/$1'); // :num = id_producto
    $routes->delete('eliminar/(:num)', 'CarritoController::eliminarProducto/$1'); // :num = id_producto
    $routes->delete('vaciar/(:num)', 'CarritoController::vaciarCarrito/$1'); // :num = id_usuario
});
*/

// CRUD Carrito
$routes->get('carrito/usuario/(:num)', 'CarritoController::obtenerCarrito/$1');
$routes->post('carrito/agregar', 'CarritoController::agregar');
$routes->put('carrito/editar/(:num)', 'CarritoController::editarProducto/$1');
$routes->delete('carrito/eliminar/(:num)', 'CarritoController::eliminarProducto/$1');

// CRUD Pedido
$routes->get('pedido', 'PedidoController::index');               // Listar pedidos
$routes->get('pedido/(:num)', 'PedidoController::show/$1');     // Ver pedido
$routes->post('pedido/crear', 'PedidoController::crear');       // Crear pedido
$routes->put('pedido/editar/(:num)', 'PedidoController::update/$1'); // Editar pedido
$routes->delete('pedido/eliminar/(:num)', 'PedidoController::delete/$1'); // Eliminar pedido

// CRUD Pedido Detalle
$routes->get('pedido_detalle/(:num)', 'PedidoDetalleController::mostrarPorPedido/$1');      // Ver detalles de un pedido
$routes->post('pedido_detalle/agregar', 'PedidoDetalleController::agregar');               // Agregar detalle
$routes->put('pedido_detalle/editar/(:num)', 'PedidoDetalleController::editar/$1');        // Editar detalle
$routes->delete('pedido_detalle/eliminar/(:num)', 'PedidoDetalleController::eliminar/$1'); // Eliminar detalle


// Mostrar login (formulario) con GET
$routes->get('login', 'Home::login');

// Procesar login con POST
$routes->post('login', 'AuthController::login');

// Logout con GET para enlace simple
$routes->post('logout', 'AuthController::logout');



/*
$routes->get('login', 'Home::loginForm'); // Mostrar vista
$routes->post('login', 'AuthController::login'); // Procesar login
*/
//register
$routes->get('register', 'Home::registerForm');       // Muestra formulario
$routes->post('register', 'UserController::crear');   // Procesa registro
// redireccionamiento a admin/user
$routes->get('admin/panel', 'Home::admin_panel');
$routes->get('admin/principal', 'Home::admin_principal_view');
$routes->get('admin/quienes_somos', 'Home::admin_quienes_somos');
$routes->get('admin/comercializacion', 'Home::admin_comercializacion');
$routes->get('admin/contacto', 'Home::admin_contacto');
$routes->get('admin/terminos_usos', 'Home::admin_terminos_usos');
$routes->get('/usuario', 'Home::usuario');





if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
