<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'IndexDungeon/index';
$route['404_override'] = 'home/notf';
$route['translate_uri_dashes'] = FALSE;

//ADMIN
$route['admin'] = 'admin/dashboard';
$route['admin/location/country/add'] = 'admin/location/country_add';
$route['admin/location/country/edit/(:num)'] = 'admin/location/country_edit/$1';
$route['admin/location/country/del/(:num)'] = 'admin/location/country_del/$1';
$route['admin/location/state/add'] = 'admin/location/state_add';
$route['admin/location/state/edit/(:num)'] = 'admin/location/state_edit/$1';
$route['admin/location/state/del/(:num)'] = 'admin/location/state_del/$1';
$route['admin/location/city/add'] = 'admin/location/city_add';
$route['admin/location/city/edit/(:num)'] = 'admin/location/city_edit/$1';
$route['admin/location/city/del/(:num)'] = 'admin/location/city_del/$1';
//DUNGEON
$route['admin'] = 'admin/auth/index';
$route['dungeon'] = 'IndexDungeon/index';
$route['dungeon/item'] = 'webgame/item/index';
$route['dungeon/credits/(:any)'] = 'IndexDungeon/credits/$1';
$route['dungeon/attack/(:any)'] = 'webgame/attack/index/$1';
$route['dungeon/(:any)'] = 'IndexDungeon/$1';
$route['dungeon/(:any)/(:any)'] = 'webgame/$1/$2';
$route['dungeon/(:any)/(:any)/(:any)'] = 'webgame/$1/$2/$3';
//CREATE
$route['create/(:any)'] = 'IndexCreate/$1';

// OTHER
$route['news'] = 'other/news/index';
$route['news/(:any)'] = 'other/news/quest/$1';
$route['notecode'] = 'other/Notecode/index';
