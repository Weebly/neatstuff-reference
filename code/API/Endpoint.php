<?php
/**
 * Endpoint handles requests to the 
 *
 *
 *
 *
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

	private static function handleResponse( $result )
	{
		if ( isset( $result['success'] ) !== true ) {
			$result['success'] = false;
		}

		\Output\Controller::toJson( $result );
	}
}
