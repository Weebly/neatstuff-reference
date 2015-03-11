<?php
/**
 *
 *
 *
 *
 *
 */
namespace Output;

class Controller
{
  /**
   *
   *
   *
   */
  public static function toJson( $output )
  {
    print_r( json_encode( $output ) );
    exit( );
  }
}