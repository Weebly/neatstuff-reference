<?php
/**
 * Endpoint requires our boostrap file, and sends the request to \API\Endpoint
 *
 * @package NeatstuffReference
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
require_once( __DIR__ . '/bootstrap/Init.php' );

\API\Endpoint::handleRequest( $_POST );
