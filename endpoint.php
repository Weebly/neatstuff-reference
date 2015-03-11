<?php
/**
 * Endpoint simply requires our boostrap files, and sends the request to \API\Endpoint
 *
 * @package 
 *
 *
 */
require_once( __DIR__ . '/bootstrap/Init.php' );

\API\Endpoint::handleRequest( $_POST );
