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
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['forgot-password'] = 'auth/forgot_password';
$route['register'] = 'auth/register';

$route['admin/users'] = 'admin/user_management';
$route['admin/users/create'] = 'admin/user_management/create_user';
$route['admin/users/edit/(:num)'] = 'admin/user_management/edit_user/$1';
$route['admin/users/delete/(:num)'] = 'admin/user_management/delete_user/$1';
$route['admin/users/deactivate/(:num)'] = 'admin/user_management/deactivate/$1';
$route['admin/users/activate/(:num)'] = 'admin/user_management/activate/$1';

$route['admin/groups'] = 'admin/user_management/groups';
$route['admin/groups/create'] = 'admin/user_management/create_group';
$route['admin/groups/edit/(:num)'] = 'admin/user_management/edit_group/$1';
$route['admin/groups/delete/(:num)'] = 'admin/user_management/delete_group/$1';
