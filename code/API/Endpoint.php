<?php
/**
 * API\Endpoint receives requests routed by the exposed endpoint.php,
 * sending them to a "listening" controller, if applicable
 *
 * @package NeatstuffReference
 * @subpackage API
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
namespace API;

class Endpoint
{
	/**
	 * Our only exposed API methods
	 * @var $methodMap
	 */
	private static $methodMap = array(
		'user::create' => '\\User\\Controller::create',
		'user::login' => '\\User\\Controller::login'
	);

	/**
 	 * Determines if the requested method is exposed, and routes the request to the waiting controller
 	 *
 	 * @param array $request
 	 *
 	 * @return void
	 */
	public static function handleRequest( $request )
	{
		if ( in_array( $request['method'], array_keys( self::$methodMap ) ) === true ) {
			$method = explode( '::', self::$methodMap[$request['method']] );
			unset( $request['method'] );
			$result = call_user_func_array( $method, array( 'request' => $request ) );
		} else {
			$result = array(
				'success' => false,
				'message' => 'Method not found'
			);
		}

		self::handleResponse( $result );
	}

	/**
 	 * Receives a response object from the handling of the request
 	 * Uses \Output\Controller to respond to the caller
 	 *
 	 * @param array $result
 	 *
 	 * @return void
 	 */
	private static function handleResponse( $result )
	{
		if ( isset( $result['success'] ) !== true ) {
			$result['success'] = false;
		}

		\Output\Controller::toJson( $result );
	}
}
