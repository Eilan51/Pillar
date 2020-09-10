<?php
use Core\Routing\Route;

Route::get('/', 'index');

// Error routing
Route::error('404', 'pages.error.404');
Route::error('403', 'pages.error.403');
Route::error('500', 'pages.error.500');
