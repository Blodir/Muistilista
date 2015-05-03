<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

//pääsivu
$routes->get('/', function() {
    HelloWorldController::index();
});

//html suunnitelmat

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/tasks', function() {
    HelloWorldController::task_list();
});

$routes->get('/tasks/1', function() {
    HelloWorldController::task_show();
});

$routes->get('/newtask', function() {
    HelloWorldController::task_edit();
});

/* $routes->get('/login', function() {
  HelloWorldController::login();
  });
 */

//käytössä olevat sivut

$routes->get('/askareet', 'check_logged_in', function() {
    AskareetController::index();
});

$routes->post('/askare', function() {
    AskareetController::store();
});

$routes->get('/askare/uusi', 'check_logged_in', function() {
    AskareetController::uusi();
});

$routes->get('/askare/:id', 'check_logged_in', function($id) {
    AskareetController::show($id);
});

$routes->get('/askare/:id/muokkaa', 'check_logged_in', function($id) {
    AskareetController::muokkaa($id);
});

$routes->post('/askare/:id/muokkaa', function($id) {
    AskareetController::update($id);
});

$routes->post('/askare/:id/destroy', function($id) {
    AskareetController::destroy($id);
});

$routes->get('/login', function() {
    UserController::login();
});
$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->post('/logout', function() {
    UserController::logout();
});

$routes->get('/luokka/:id', function ($id){
    LuokatController::show($id);
});

$routes->post('/luokka/:id/destroy', function ($id) {
    LuokatController::destroy($id);    
});

$routes->get('/luokka/:id/muokkaa', 'check_logged_in', function($id) {
    LuokatController::muokkaa($id);
});

$routes->post('/luokka/:id/muokkaa', function($id) {
    LuokatController::update($id);
});

$routes->get('/register', function() {
    UserController::register();
});

$routes->post('/register', function() {
    UserController::store();
});