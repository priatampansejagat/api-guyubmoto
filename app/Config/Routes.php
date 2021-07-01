<?php

namespace Config;

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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');


$routes->group('family', function($routes){

	$routes->group('myworks', function($routes){
		$routes->add('photography/list_photography', 'Family\MyWorks\Photography::list_photography');
		$routes->add('photography/count_photography', 'Family\MyWorks\Photography::count_photography');
		$routes->add('photography/delete_photography', 'Family\MyWorks\Photography::delete_photography');
		$routes->add('photography/upload', 'Family\MyWorks\Photography::upload');
		$routes->add('photography/upload_file', 'Family\MyWorks\Photography::upload_file');
	});

	$routes->group('aboutme', function($routes){
		$routes->add('biography/refresh', 'Family\AboutMe\Biography::refresh');
		$routes->add('biography/update', 'Family\AboutMe\Biography::update');
		$routes->add('biography/updateProfilePic', 'Family\AboutMe\Biography::updateProfilePic');
	});

});
/*
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
