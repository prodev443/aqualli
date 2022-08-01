<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

 // Home
 $routes->get('home', 'HomeController');

// Login
$routes->group('login', function($routes){
	$routes->get('', 'Login::index');
	$routes->get('signin', 'Login::signin');
	$routes->get('signout', 'Login::signout');
});

// Administración del sistema
$routes->group('system', function($routes){
	$routes->get('', 'SystemController::index');
	$routes->get('resources/roles', 'SystemController::getRoles');
	$routes->get('resources/modules', 'SystemController::getModules');
	$routes->get('resources/permissions/(:num)', 'SystemController::getPermissions/$1');
	$routes->post('resources/permissions/save', 'SystemController::savePermissions');
	$routes->post('resources/permissions/delete', 'SystemController::deletePermissions');
	$routes->get('roles', 'SystemController::listRoles');
	$routes->get('roles/(:num)', 'SystemController::detailRole/$1');
});

// Gestión de usuarios
$routes->group('users', function($routes){
	$routes->get('', 'UsersController::index');
	$routes->get('create', 'UsersController::create');
	$routes->get('detail/(:segment)', 'UsersController::detail/$1');
	$routes->get('edit/(:segment)', 'UsersController::edit/$1');
	$routes->get('update_password/(:num)', 'UsersController::showPasswordUpdatePopup/$1');
	$routes->get('resources/list', 'UsersController::listJSON');
	$routes->post('resources/insert', 'UsersController::insert');
	$routes->post('resources/update', 'UsersController::update');
	$routes->delete('resources/delete', 'UsersController::delete');
});

// Estudiantes
$routes->group('students', function($routes){
	$routes->get('', 'StudentsController');
	$routes->get('create', 'StudentsController::create');
	$routes->get('detail/(:num)', 'StudentsController::detail/$1');
	$routes->get('edit/(:num)', 'StudentsController::edit/$1');
	$routes->group('resources', function($routes){
		$routes->get('get', 'StudentsController::get');
		$routes->get('get/(:num)', 'StudentsController::get/$1');
		$routes->get('select2', 'StudentsController::select2Students');
		$routes->get('getphoto/(:num)', 'StudentsController::getPhoto/$1');
		$routes->post('insert', 'StudentsController::insert');
		$routes->post('update', 'StudentsController::update');
		$routes->delete('delete', 'StudentsController::delete');
		$routes->delete('delete_photo', 'StudentsController::deletePhoto');
	});
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}