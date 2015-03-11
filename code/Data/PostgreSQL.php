<?php
/**
 *
 *
 *
 *
 *
 */
namespace Data;

class PostgreSQL
{
  const DEFAULT_IDENTIFIER = 'userData';
  const USER_DATA_IDENTIFIER = 'userData';

  private static $instances = NULL;

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