<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
/**
 * Initialisations
 *
 * Register an autoloader, start or resume the session etc.
 */

spl_autoload_register(function ($class) {
    //require "classes/{$class}.php";
    //require "../classes/{$class}.php";
    require dirname(__DIR__) . "/classes/{$class}.php";
});

if (!isset($_SESSION)) {
    session_start();
}
