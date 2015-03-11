<?php
/**
 * API\Exception handles responding to an API request in the event of an error
 *
 * @pacakge NeatstuffReference
 * @subpackage API
 * @author Dustin Doiron <dustin@weebly.com>
 * @since
 */
namespace API;

class Exception
{
  const DEFAULT_EXCEPTION = 'An error has occurred';

  /**
   * Constructor, receives a message string and uses \Output\Controller to respond to the caller
   *
   * @param string $message
   *
   * @return void
   */
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
