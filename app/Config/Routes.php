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
$routes->get('/principal', 'Home::index');
$routes->get('quienes_somos', 'Home::quienes_somos');
$routes->get('Contacto', 'Home::Contacto'); // Para mostrar la vista
$routes->post('Contacto', 'ContactoController::Enviar'); // Para procesar
$routes->get('Comercializacion', 'home::Comercializacion'); 
$routes->get('termino_usos', 'home::termino_usos');
$routes->get('footer', 'home::footer');
$routes->get('catalogo', 'Home::catalogo');
$routes->get('producto/(:num)', 'Home::verProducto/$1');



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


// Grupo de rutas para el carrito (protegidas por autenticación)
$routes->group('carrito', ['filter' => 'auth'], function($routes) {
    $routes->get('usuario/(:num)', 'CarritoController::obtenerCarrito/$1');
    $routes->get('(:num)', 'Home::carrito/$1');
    $routes->post('agregar', 'CarritoController::agregar');
    $routes->post('finalizar', 'CarritoController::finalizar');
    $routes->post('actualizar/(:num)', 'CarritoController::actualizar/$1'); // :num = id_producto
    $routes->post('eliminar/(:num)', 'CarritoController::eliminar/$1'); // :num = id_producto
    $routes->post('vaciar/(:num)', 'CarritoController::vaciar/$1'); // :num = id_usuario
});


// Rutas para clientes
$routes->group('pedidos', function($routes) {
    $routes->get('mis-pedidos', 'PedidosController::misPedidos');
    $routes->get('ver/(:num)', 'PedidosController::verPedido/$1');
    $routes->post('finalizar-compra', 'PedidosController::finalizarCompra');
});


// Mostrar login (formulario) con GET
$routes->get('login', 'Home::login');

// Procesar login con POST
$routes->post('login', 'AuthController::login');

// Logout con GET para enlace simple
$routes->post('logout', 'AuthController::logout');

//register
$routes->get('register', 'Home::registerForm');       // Muestra formulario
$routes->post('register', 'UserController::crear');   // Procesa registro

// redireccionamiento a admin/user
$routes->get('admin/panel', 'Home::admin_panel');
$routes->get('admin/usuarios',   'Home::admin_usuarios');
// Rutas para ProductController
// Listado de productos (Admin)
$routes->get(  'admin/productos','Home::admin_productos');
// Formulario de edición (GET) —> ahora en Home
$routes->get(  'admin/productos/modificar/(:segment)','Home::admin_editar_producto/$1');
// Procesar actualización (POST) —> en ProductoController
$routes->post( 'admin/productos/actualizar/(:segment)','ProductoController::actualizar/$1');
// Crear producto (POST)  
$routes->post( 'admin/panel/crear','ProductoController::crear');
$routes->get('admin/catalogo', 'Home::catalogo_admin');
$routes->get('admin/principal', 'Home::admin_principal_view');
$routes->get('admin/quienes_somos', 'Home::admin_quienes_somos');
$routes->get('admin/comercializacion', 'Home::admin_comercializacion');
$routes->get('admin/contacto','Home::admin_contacto');
$routes->get('admin/terminos_usos', 'Home::admin_terminos_usos');
$routes->get('admin/lista', 'Home::admin_panel');
$routes->get('admin/usuarios', 'Home::admin_usuarios');
$routes->get('admin/perfil', 'Home::perfilAdmin');
$routes->get('admin/pedidos', 'Home::verPedidosAdmin');
$routes->post('admin/pedidos/cambiarEstado/(:num)', 'PedidosController::cambiarEstado/$1');



// Ver listado completo de consultas
$routes->get('admin/consultas', 'Home::adminConsultas');
// Mostrar formulario para responder una consulta puntual
$routes->get('admin/consultas/(:num)', 'Home::adminResponder/$1');
// Guardar la respuesta (POST)
$routes->post('admin/consultas/responder/(:num)', 'ConsultaController::guardarRespuesta/$1');
$routes->get('admin/contactos', 'ContactoController::listar');



/*usuario*/
$routes->get('usuario/', 'Home::usuario');
$routes->get('usuario/principal', 'Home::usuario');
$routes->get('usuario/quienes_somos', 'Home::quienes_somos');
$routes->get('usuario/termino_usos', 'Home::termino_usos');
$routes->get('usuario/comercializacion', 'Home::comercializacion');
$routes->get('usuario/catalogo', 'Home::catalogo');

// Mostrar el formulario
$routes->get('usuario/consultas', 'Home::formularioConsulta');
// Procesar el formulario
$routes->post('usuario/consultas', 'ConsultaController::enviar');
$routes->get('usuario/mis_consultas', 'Home::misConsultas');
$routes->post('usuarios/desactivar/(:num)', 'UserController::delete/$1');
$routes->post('usuarios/restaurar/(:num)', 'UserController::restaurar/$1');
$routes->get('usuario/perfil', 'Home::perfilUsuario');
$routes->get('usuario/pedidos', 'Home::usuario_pedidos');

$routes->get('prueba-correo', 'ContactoController::pruebaCorreo');




if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
