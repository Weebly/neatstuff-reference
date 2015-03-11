<?php
/**
 *
 *
 *
 *
 *
 *
 */
namespace Weebly;

use \Data\Configuration;

class APIClient
{
  private static $curlHandler = NULL;

  private static $curlSettings = array(
    CURLOPT_RETURNTRANSFER => true
  );

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

  public static function closeCurlHandler( )
  {
    if ( isset( self::$curlHandler ) === false ) {
      return;
    }

    curl_close( self::$curlHandler );
  }

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

  private static function generateRequestHash( $method, $url, $payload )
  {
    return hash_hmac(
      Configuration::WEEBLY_HMAC_HASH_STRATEGY,
      $method . "\n" . $url . "\n" . $payload,
      Configuration::WEEBLY_PRIVATE_KEY
    );
  }
}
