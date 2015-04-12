<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

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

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/askareet', function() {
    AskareetController::index();
});

$routes->post('/askare', function() {
    AskareetController::store();
});

$routes->get('/askare/uusi', function() {
    AskareetController::uusi();
});

$routes->get('/askare/:id', function($id) {
    AskareetController::show($id);
});
