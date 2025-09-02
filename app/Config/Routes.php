<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::Index');
$routes->get('/course', 'Course::Index');
$routes->get('/course/(:num)', 'Course::Detail/$1');
$routes->post('/course/enroll', 'Course::Enroll');

$routes->get('/calendar', 'Calendar::Index');

$routes->get('/signin', 'Authorization::Signin');
$routes->post('/signin', 'Authorization::Signin');
$routes->get('/signup', 'Authorization::Signup');
$routes->post('/signup', 'Authorization::Signup');
$routes->get('/signout', 'Authorization::Signout');

$routes->get('/forgotpwd', 'ForgotPwd::Index');
$routes->post('/forgotpwd/action', 'ForgotPwd::Action');

$routes->get('/account/info', 'Account::Info');
$routes->post('/account/info', 'Account::Info');
$routes->get('/account/changepwd', 'Account::ChangePassword');
$routes->post('/account/changepwd', 'Account::ChangePassword');

$routes->get('/enroll', 'Enroll::Index');

$routes->get('/payment', 'Payment::Index');
$routes->post('/payment', 'Payment::Index');

$routes->get('/resetpwd', 'ResetPwd::Index');
$routes->post('/resetpwd', 'ResetPwd::Index');

// Manage
$routes->setDefaultNamespace('App\Controllers\Manage');
$routes->get('/manage/courses', 'Courses::Index');
$routes->get('/manage/courses/enroll/(:num)', 'Courses::Enroll/$1');
$routes->get('/manage/courses/enroll/report/(:num)', 'Courses::EnrollReport/$1');
$routes->get('/manage/courses/categories', 'Courses::Categories');
$routes->get('/manage/lecturer', 'Lecturer::Index');
$routes->get('/manage/faculty', 'Faculty::Index');
$routes->get('/manage/enrollment', 'Enrollment::Index');
$routes->get('/manage/payment', 'Payment::Index');
$routes->get('/manage/payment/report', 'Payment::Report');
$routes->get('/manage/users', 'Users::Index');

// API
$routes->setDefaultNamespace('App\Controllers\Api');
$routes->post('/api/get/course/dt', 'CourseApi::GetDT');
$routes->get('/api/get/course/(:num)', 'CourseApi::Get/$1');
$routes->get('/api/get/course/list/bythirdparty', 'CourseApi::GetListByThirdParty');
$routes->get('/api/get/course/calendar', 'CourseApi::GetCalendar');
$routes->post('/api/create/course', 'CourseApi::Create');
$routes->post('/api/modify/course', 'CourseApi::Modify');
$routes->get('/api/delete/course/(:num)', 'CourseApi::Delete/$1');

$routes->post('/api/get/course/category/dt', 'CourseApi::GetCategoryDT');
$routes->get('/api/get/course/category/(:num)', 'CourseApi::GetCategory/$1');
$routes->post('/api/create/course/category', 'CourseApi::CreateCategory');
$routes->post('/api/modify/course/category', 'CourseApi::ModifyCategory');
$routes->get('/api/delete/course/category/(:num)', 'CourseApi::DeleteCategory/$1');

$routes->post('/api/get/course/batch/dt/(:num)', 'CourseApi::GetBatchDT/$1');
$routes->get('/api/get/course/batch/(:num)', 'CourseApi::GetBatch/$1');
$routes->post('/api/create/course/batch', 'CourseApi::CreateBatch');
$routes->post('/api/modify/course/batch', 'CourseApi::ModifyBatch');
$routes->get('/api/delete/course/batch/(:num)', 'CourseApi::DeleteBatch/$1');

$routes->post('/api/get/enroll/dt/(:segment)', 'EnrollApi::GetDT/$1');
$routes->post('/api/get/enroll/course/dt/(:num)', 'EnrollApi::GetCourseDT/$1');
$routes->post('/api/get/enroll/course/batch/dt/(:num)/(:segment)', 'EnrollApi::GetCourseBatchDT/$1/$2');
$routes->get('/api/get/enroll/(:num)', 'EnrollApi::Get/$1');
$routes->post('/api/modify/enroll', 'EnrollApi::Modify');
$routes->get('/api/delete/enroll/(:num)', 'EnrollApi::Delete/$1');
$routes->post('/api/modify/enroll/alert', 'EnrollApi::ModifyAlert');
$routes->post('/api/get/enroll/joined/dt/(:num)', 'EnrollApi::GetJoinedDT/$1');

$routes->post('/api/get/lecturer/dt', 'LecturerApi::GetDT');
$routes->get('/api/get/lecturer/(:num)', 'LecturerApi::Get/$1');
$routes->post('/api/create/lecturer', 'LecturerApi::Create');
$routes->post('/api/modify/lecturer', 'LecturerApi::Modify');
$routes->get('/api/delete/lecturer/(:num)', 'LecturerApi::Delete/$1');

$routes->post('/api/get/faculty/dt', 'FacultyApi::GetDT');
$routes->get('/api/get/faculty/(:num)', 'FacultyApi::Get/$1');
$routes->post('/api/create/faculty', 'FacultyApi::Create');
$routes->post('/api/modify/faculty', 'FacultyApi::Modify');
$routes->get('/api/delete/faculty/(:num)', 'FacultyApi::Delete/$1');

$routes->post('/api/get/branch/dt/(:num)', 'BranchApi::GetDT/$1');
$routes->get('/api/get/branch/(:num)', 'BranchApi::Get/$1');
$routes->post('/api/create/branch', 'BranchApi::Create');
$routes->post('/api/modify/branch', 'BranchApi::Modify');
$routes->get('/api/delete/branch/(:num)', 'BranchApi::Delete/$1');

$routes->post('/api/get/user/dt', 'UserApi::GetDT');
$routes->get('/api/get/user/(:num)', 'UserApi::Get/$1');
$routes->post('/api/modify/user', 'UserApi::Modify');
$routes->get('/api/delete/user/(:num)', 'UserApi::Delete/$1');

$routes->post('/api/get/payment/dt/(:segment)', 'PaymentApi::GetDT/$1');
$routes->get('/api/get/payment/(:num)', 'PaymentApi::Get/$1');
$routes->post('/api/modify/payment', 'PaymentApi::Modify');
$routes->get('/api/delete/payment/(:num)', 'PaymentApi::Delete/$1');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
