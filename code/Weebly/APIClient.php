<?php
/**
 * Weebly\APIClient performs API requests to the Weebly Cloud for Hosts API
 *
 * @package NeatstuffReference
 * @subpackage Weebly
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
namespace Weebly;

use \Data\Configuration;

class APIClient
{
  /**
   * @var $curlHandler
   */
  private static $curlHandler = NULL;

  /**
   * Default CURL settings
   * @var $curlSettings
   */
  private static $curlSettings = array(
    CURLOPT_RETURNTRANSFER => true
  );

  /**
   * Retrieves the static instance of CURL
   * If one does not exist, create one
   *
   * @return instanceof \curl
   */
  private static function getCurlHandler( )
  {
    if ( isset( self::$curlHandler ) === false ) {
      self::$curlHandler = curl_init( );
      register_shutdown_function(
        function( ) {
          \Weebly\APIClient::closeCurlHandler( );
        }
      );
    }

    return self::$curlHandler;
  }

  /**
   * Closes the static CURL handler, if one exists
   *
   * @return void
   */
  public static function closeCurlHandler( )
  {
    if ( isset( self::$curlHandler ) === false ) {
      return;
    }

    curl_close( self::$curlHandler );
  }

  /**
   * Performs a POST to the Weebly Cloud for Hosts API with the given URL and payload
   *
   * @param string $url
   * @param mixed $payload
   *
   * @return array
   */
  public static function post( $url, $payload )
  {
    $curl = self::getCurlHandler( );

    if ( is_array( $payload ) === true ) {
      $payload = json_encode( $payload );
    }

    $options = array(
      CURLOPT_URL => Configuration::WEEBLY_ENDPOINT . $url,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $payload,
      CURLOPT_HTTPHEADER => array(
        'X-Public-Key: ' . Configuration::WEEBLY_PUBLIC_KEY,
        'X-Signed-Request-Hash: ' . self::generateRequestHash( 'POST', $url, $payload ),
        'Content-type: application/json'
      )
    );

    curl_setopt_array( $curl, $options + self::$curlSettings );
    return json_decode( curl_exec( $curl ), true );
  }

  /**
   * Generates a request hash from the given method, URL, and encoded payload
   *
   * @param string $method
   * @param string $url
   * @param string $payload
   *
   * @return string
   */
  private static function generateRequestHash( $method, $url, $payload )
  {
    return hash_hmac(
      Configuration::WEEBLY_HMAC_HASH_STRATEGY,
      $method . "\n" . $url . "\n" . $payload,
      Configuration::WEEBLY_PRIVATE_KEY
    );
  }
}
