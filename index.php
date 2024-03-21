<?php
ob_start();
require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use Source\Core\Session;
use CoffeeCode\Router\Router;

$session = new Session();
$route = new Router(url(), "@");

/**
 * Home ROUTES
 */
$route->namespace("Source\App");
$route->get("/", "HomeController@home");

/**
 * Auth ROUTES
 */
$route->group(null);
$route->get("/login", "AuthController@login");
$route->post("/login", "AuthController@login");
$route->get("/register", "AuthController@register");
$route->post("/register", "AuthController@register");
$route->get("/logout", "AuthController@logout");
$route->get("/forget", "AuthController@forget");
$route->post("/forget", "AuthController@forget");
$route->get("/forget/{code}", "AuthController@reset");
$route->post("/forget/reset", "AuthController@reset");

/**
 * COMPANY ROUTES
 */
$route->group("/company");
$route->get("", "CompanyController@search");
$route->post("", "CompanyController@search");
$route->get("/{type}/{search}/{date_start}/{date_final}/{order}/{page}", "CompanyController@search");
$route->post("/register", "CompanyController@register");
$route->get("/update/{company}", "CompanyController@update");
$route->post("/update/{company}", "CompanyController@update");
$route->get("/remove/{company}", "CompanyController@remove");


/**
 * SECTORS ROUTES
 */
$route->group("/sector");
$route->get("", "SectorController@search");
$route->post("", "SectorController@search");
$route->get("/{type}/{search}/{date_start}/{date_final}/{order}/{page}", "SectorController@search");
$route->post("/register", "SectorController@register");
$route->get("/update/{id}", "SectorController@update");
$route->post("/update/{id}", "SectorController@update");
$route->get("/remove/{id}", "SectorController@remove");

/**
 * STATUS ROUTES
 */
$route->group("/status");
$route->get("", "StatusController@search");
$route->post("", "StatusController@search");
$route->get("/{type}/{search}/{date_start}/{date_final}/{order}/{page}", "StatusController@search");
$route->post("/register", "StatusController@register");
$route->get("/update/{id}", "StatusController@update");
$route->post("/update/{id}", "StatusController@update");
$route->get("/remove/{id}", "StatusController@remove");

/**
 * USERS ROUTES
 */
$route->group("/user");
$route->get("", "UserController@search");
$route->post("", "UserController@search");
$route->get("/{type}/{search}/{date_start}/{date_final}/{order}/{page}", "UserController@search");
$route->get("/register", "UserController@register");
$route->post("/register", "UserController@register");
$route->get("/update/{id}", "UserController@update");
$route->post("/update/{id}", "UserController@update");
$route->get("/remove/{id}", "UserController@remove");

/**
 * UPLOADS ROUTES
 */
$route->group("/upload");
$route->get("", "UploadController@search");
$route->post("", "UploadController@search");
$route->get("/{status}/{type}/{search}/{date_start}/{date_final}/{order}/{page}", "UploadController@search");
$route->post("/register", "UploadController@register");
$route->get("/update/{id}/{status}", "UploadController@update");
$route->get("/remove/{id}", "UploadController@remove");

/**
 * ERROR ROUTES [400, 404,405, 501]
 */
$route->namespace("Source\App")->group("/ops");
$route->get("/{errcode}", "ErrorController@error");

/**
 * ROUTE
 */
$route->dispatch();


/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
