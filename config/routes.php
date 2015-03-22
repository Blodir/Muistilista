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
