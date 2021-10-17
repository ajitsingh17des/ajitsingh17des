<?php namespace Config;

/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

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
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
 

$url =  $_SERVER['REQUEST_URI'];
$urlArr = explode('/',$url);
$endUrl = end($urlArr);
$endArr = explode('-', $endUrl);
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');

$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function() {
	return view('frontend/custom404');
});

$routes->setAutoRoute(true);

/*---Frontend url start--*/
$routes->get('testimonials', 'Testimonials::index');
$routes->get('notices_and_announcements', 'Notices_and_announcements::index');
$routes->get('iqac-meeting-proceedings', 'IqacMeetingProceedings::index');
$routes->get('nirf', 'Nirf::index');
$routes->get('trustees', 'Trustees::index');
$routes->get('careers', 'Careers::index');
$routes->get('about-us', 'AboutUS::index');
$routes->get('events', 'Events::index');
$routes->get('news', 'News::index');
$routes->get('events/(:any)', 'Events::showEventsDetail/$1');
$routes->get('news/(:any)', 'News::showNewsDetail/$1');
//$routes->get("sample-route/(:any)/(:num)", "MyController::sampleRoute/$1/$2");
/*---Frontend url end--*/
/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


/**************Common  routes define here******/




$routes->get('backoffice', 'Home::backoffice');
$routes->get('/(:segment)', 'Cms::common_cms/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
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

