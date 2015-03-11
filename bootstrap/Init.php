<?php
/**
 *
 *
 *
 *
 */
require_once( __DIR__ . '/ClassLoader.php' );
define( 'BASE_SERVICES_DIRECTORY', __DIR__ . '/../code/' );

$loader = new \Symfony\Component\ClassLoader\ClassLoader( );
$loader->registerNamespaceFallback( \BASE_SERVICES_DIRECTORY );
$loader->register( );