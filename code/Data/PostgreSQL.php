<?php
/**
 * Data\PostgreSQL retrieves static instances of a (hopefully!) connected \PDO object
 *
 * @package NeatstuffReference
 * @package Data
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
namespace Data;

use \PDO;
use \Exception;

class PostgreSQL
{
  const DEFAULT_IDENTIFIER = 'userData';
  const USER_DATA_IDENTIFIER = 'userData';

  /**
   * Static \PDO instances
   * @var $instances
   */
  private static $instances = NULL;

  /**
   * Retrieves an instance of \PDO based on the given identifier
   * If one does not exist, creates it
   *
   * @param string $identifier
   * @return instanceof \PDO
   * @throws \Exception
   */
  public static function getInstance( $identifier )
  {
    if ( isset( $identifier ) === false ) {
      $identifier = self::DEFAULT_IDENTIFIER;
    }

    if ( isset( self::$instances[$identifier] ) === false ) {
      try
      {
        $pdo = new \PDO( Configuration::$postgresql[$identifier] );
        self::$instances[$identifier] = $pdo;
      }
      catch ( \PDOException $e )
      {
        throw new \Exception( $e->getMessage( ) );
      }
    }

    return self::$instances[$identifier];
  }
}
