<?php

$router->add('GET', '/', 'Front\HomeController@index');
$router->add('GET', '/login', 'Front\AuthController@login');
$router->add('POST', '/login', 'Front\AuthController@login');
$router->add('GET', '/signup', 'Front\AuthController@signup');
$router->add('POST', '/signup', 'Front\AuthController@signup');
$router->add('GET', '/logout', 'Front\AuthController@logout');
$router->add('GET', '/Admin', 'Back\AdminController@index');
$router->add('GET', '/Admin/Announcements', 'Back\AnnouncementsController@index');
$router->add('GET', '/Admin/Companies', 'Back\AdminController@companies');
$router->add('POST', '/Admin/Companies', 'Back\CompanyController@store');
$router->add('GET', '/Home', 'Front\UserController@index');


// the announcments routes
$router->add('POST', '/announce/create', 'Back\AnnouncementsController@create');
$router->add('GET', '/announce/edit', 'Back\AnnouncementsController@showEditForm');
$router->add('POST', '/announce/edit', 'Back\AnnouncementsController@updateAnnounce');
$router->add('GET', '/announce/delete', 'Back\AnnouncementsController@deleteAnnounce');


