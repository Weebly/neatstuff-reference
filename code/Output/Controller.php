<?php
/**
 * Output\Controller handles basic output to respond to client API requests
 *
 * @package NeatstuffReference
 * @subpackage Output
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
namespace Output;

class Controller
{
  /**
   * Converts the given array to JSON, prints, exits
   *
   * @param array $output
   *
   * @return void
   */
  public static function toJson( $output )
  {
    print_r( json_encode( $output ) );
    exit( );
  }
}
