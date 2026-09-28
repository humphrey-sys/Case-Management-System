<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');

// Auth routes
//$routes->post('store_user', 'Auth::store_user');
$routes->get('/login', 'Auth::loginForm');
$routes->post('/login', 'Auth::login');
$routes->post('/verify-otp', 'Auth::verifyOtp');

//$routes->post('/login', 'Auth::authenticate');
//$routes->post('authenticate', 'Auth::authenticate');
$routes->get('dashboards/superadmin', 'Auth::superadmin', ['filter' => 'role:superadmin']);
$routes->get('dashboards/admin', 'Auth::admin', ['filter' => 'role:admin']);
$routes->get('dashboards/officer', 'Auth::officer', ['filter' => 'role:officer']);
$routes->get('/Home', 'Auth::Home');
$routes->get('/about', 'Auth::about');
$routes->get('/verify-otp', 'Auth::verifyOtpForm');
$routes->post('/verify-otp', 'Auth::verifyOtp');
$routes->post('/change-password', 'Auth::changePassword');


// Case Management Routes
$routes->post('/store_case', 'Auth::store_case');
$routes->post('/fetch_cases', 'Auth::fetch_cases');
$routes->get('admin/fetch_user', 'Users::fetch_user');
$routes->get('fetch_users', 'Users::fetch_users');
$routes->get('fetch_cases', 'Cases::fetch_cases');
$routes->get('fetch_cases_by_region', 'Cases::fetch_cases_by_region');
$routes->get('case_details/(:num)', 'Cases::case_details/$1');
$routes->get('case/edit_case/(:num)', 'Cases::edit_case/$1');
$routes->post('case/update_case', 'Cases::update_case');
$routes->delete('delete_case/(:num)', 'Cases::delete_case/$1');

$routes->get('cases/resolved-this-month', 'Auth::getCasesResolvedThisMonth');
$routes->get('dashboardsearch', 'Cases::dashboardsearch');

$routes->get('get_user/(:num)', 'Users::getUser/$1');
$routes->delete('user/delete_user/(:num)', 'Users::delete_user/$1');
$routes->get('user/edit_user/(:num)', 'Users::edit_user/$1');
//$routes->get('edit-profile', 'Users@editProfile', ['as' => 'editProfile']);
$routes->get('user/profile', 'Users::profile');
$routes->post('user/update_profile', 'Users::updateProfile');
$routes->get('officer/fetch_cases/(:num)', 'Cases::fetchCases/$1');
$routes->post('user/update_user', 'Users::update_user');
$routes->get('fetch_cases_by_officer', 'Cases::fetch_cases_by_officer');
$routes->get('officer/fetch_cases', 'Cases::fetch_cases_by_officer');
$routes->post('users/register', 'Users::registerUser');
$routes->get('accessLogs/fetchLogs', 'AccessLogs::fetchLogs');
$routes->get('accessLogs/exportLogs', 'AccessLogs::exportLogs');


$routes->get('settings/fetchSettings', 'Setting::fetchSettings');
$routes->post('settings/updateSettings', 'Setting::updateSettings');
$routes->post('settings/resetDefaults', 'Setting::resetDefaults');


// Update user details
$routes->get('password/reset', 'PasswordController::resetForm'); // Display reset form
$routes->post('password/reset', 'PasswordController::processReset'); // Handle reset logic
$routes->get('password/reset/(:hash)', 'PasswordController::showResetPasswordForm/$1'); // Show the password reset page
$routes->post('password/update', 'PasswordController::updatePassword'); // Update the password

$routes->get('officer/notifications', 'Notifications::fetchOfficer');
$routes->get('notifications/markAsRead/(:num)', 'Notifications::markAsRead/$1');
$routes->get('notifications/delete/(:num)', 'Notifications::delete/$1');
$routes->get('superadmin/notifications', 'Notifications::superadminNotifications');
$routes->get('admin/notifications', 'Notifications::adminNotifications');


$routes->get('/superadmin/reports', 'Reports::superadminReports');
$routes->get('reports/download-case-txt/(:num)', 'Reports::downloadTxt/$1');
$routes->get('reports/download-case-pdf/(:num)', 'Reports::downloadPdf/$1');
$routes->get('reports/download-case-docx/(:num)', 'Reports::downloadDocx/$1');

$routes->post('contact/send', 'Contact::send');











