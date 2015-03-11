<?php
namespace API;

class Exception
{
  const DEFAULT_EXCEPTION = 'An error has occurred';

  public function __construct( $message )
  {
    if ( isset( $message ) === false ) {
      $message = self::DEFAULT_EXCEPTION;
    }

    \Output\Controller::toJson(
      array(
        'success' => false,
        'message' => $message
      )
    );
  }
}