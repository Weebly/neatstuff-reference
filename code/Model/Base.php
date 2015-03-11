<?php
/**
 * Ever started writing a project and say to your teamate, "Hey, let's not write an ORM?"
 * \Model\Base is the ORM which controls data held in the reference application's models
 * See the README.md in this folder for more details on how this works, known bugs, etc
 *
 * @package NeatstuffReference
 * @subpackage Model
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
namespace Model;

use \Data\PostgreSQL;
use \ReflectionClass;
use \PDO;

abstract class Base
{
  const SCHEMA = 'neatstuff.';

  /**
   * The data provider associated with acting upon this model
   * @var $dataProvider
   */
  private $dataProvider;

  /**
   * The primary key associated with this model
   * @var $primaryKey
   */
  private $primaryKey;

  /**
   * The state of the model at the time it was constructed
   * @var $constructState
   */
  private $constructState;

  /**
   * The Primary Key value we're using to look up this model
   * @var $pkValue
   */
  private $pkValue = NULL;

  /**
   * The table associated with this model
   * @var $table
   */
  public $table = NULL;

  /**
   * CRUD methods should ignore member variables which are named the following
   * @var $ignores
   */
  private $ignores = array(
    'dataProvider',
    'primaryKey',
    'constructState',
    'pkValue',
    'ignores',
    'table'
  );

  /**
   * Constructor, builds a representation of the model to be acted upon
   * If a Primary Key value is given, uses that to perform a lookup of an existing model
   *
   * @param mixed $pkValue
   *
   * @return void
   */
  public function __construct( $pkValue = NULL )
  {
    if ( isset( $this->table ) === false ) {
      $class = new \ReflectionClass( $this );
      $this->table = strtolower( $class->getShortName( ) );
      unset( $class );
    }

    $this->dataProvider = $this->getDataProvider( );
    $this->primaryKey = $this->getPrimaryKey( );

    if ( $pkValue !== NULL ) {
      $this->pkValue = $pkValue;
      $this->getModelData( $this->getPrimaryKey( ), $this->pkValue );
    }

    $this->constructState = \get_object_vars( $this );
  }

  /**
   * Saves the current model to the data provider, if needed
   * Determines need by calculating the delta of constructState to the current state, which is a bit... heavy
   *
   * @return bool
   */
  public function save( )
  {
    $changed = array( );

    foreach ( \get_object_vars( $this ) as $property => $value ) {
      if ( in_array( $property, $this->ignores ) === false ) {
        if ( $this->constructState[$property] !== $value ) {
          $changed[$property] = $value;
        }
      }
    }

    if ( count( $changed ) > 0 ) {
      if ( $this->isUpdate( ) === true ) {
        return $this->update( $changed );
      } else {
        return $this->insert( $changed );
      }
    }
  }

  /**
   * Updates the current, existing, model with the given changed values with the data provider
   *
   * @param array $changed
   *
   * @return bool
   * @throws \Exception
   */
  private function update( $changed )
  {
    if ( isset( $this->primaryKey ) === false ) {
      throw new \Exception( 'Attempting to update without a primary key on table ' . self::SCHEMA . $this->table );
    }

    $query = 'UPDATE ' . self::SCHEMA . $this->table . ' SET ';

    foreach ( $changed as $column => $value ) {
      $query .= $column . ' = ? ';
    }

    $query = rtrim( $query, ', ' );
    $query .= ' WHERE ' . $this->primaryKey . ' = ?';

    $statement = $this->dataProvider->prepare( $query );

    $x = 1;
    foreach ( $changed as $column => $value )
    {
      $statement->bindValue( $x, $value );
      $x++;
    }

    $statement->bindValue( $x, $this->pkValue );

    try
    {
      $statement->execute( );
      return true;
    }
    catch ( \PDOException $e )
    {
      throw new \Exception( 'Could not save model, ' . self::SCHEMA . $this->table . ':' . $this->primaryKey . ', ' . $e->getMessage( ) );
    }
  }

  /**
   * Inserts the newly created model into the data provider
   *
   * @param array $changed
   *
   * @return bool
   * @throws \Exception
   */
  public function insert( $changed )
  {
    $query = 'INSERT INTO ' . self::SCHEMA . $this->table . ' ( ';

    $columns = '';
    $values = '';

    foreach ( $changed as $column => $value ) {
      $columns .= $column . ', ';
      $values .= '? , ';
    }

    $query .= trim( $columns, ', ' );
    $query .= ' ) VALUES ( ';
    $query .= trim( $values, ', ' );
    $query .= ' )';

    $statement = $this->dataProvider->prepare( $query );

    $x = 1;
    foreach ( $changed as $column => $value ) {
      $statement->bindValue( $x, $value );
      $x++;
    }

    if ( $statement->execute( ) === true ) {
      return true;
    }
    else {
      throw new \Exception( 'Could not save model, ' . self::SCHEMA . $this->table . ':' . $this->primaryKey . ', ' . var_export( $statement->errorInfo( ), true ) );
    }
  }

  /**
   * Determines if the save method will be an insert or update by referencing the current state of the model,
   * or by querying the data provider to determine if the model already exists
   *
   * @return bool
   */
  private function isUpdate( )
  {
    if ( $this->pkValue !== NULL ) {
      return true;
    }

    $statement = $this->dataProvider->prepare(
      'SELECT true AS exists FROM ' . self::SCHEMA . $this->table . ' WHERE ' . $this->primaryKey . ' = :PK'
     );

    $statement->bindParam( ':PK', $this->pkValue );

    if ( $statement->execute( ) === true ) {
      $result = $statement->fetch( \PDO::FETCH_ASSOC );
      if ( $result['exists'] !== NULL ) {
        return true;
      }
    }

    return false;
  }

  /**
   * Populates the current model with the given Primary Key and lookup value
   *
   * @param string $primaryKey
   * @param mixed $value
   *
   * @return void
   */
  private function getModelData( $primaryKey, $value )
  {
    $statement = $this->dataProvider->prepare(
      'SELECT * FROM ' . self::SCHEMA . $this->table . ' WHERE ' . $primaryKey . ' = :PK'
    );

    $statement->bindParam( ':PK', $value );

    if ( $statement->execute( ) === true ) {
      $result = $statement->fetch( \PDO::FETCH_ASSOC );

      if ( $result === NULL || $result === false ) {
        return;
      }

      foreach ( $result as $key => $value ) {
        $this->$key = $value;
      }
    }
  }

  /**
   * Retreives the data provider for the model, which is always PostgreSQL at this point
   *
   * @return instanceof \PDO
   */
  private function getDataProvider( )
  {
    return PostgreSQL::getInstance( PostgreSQL::USER_DATA_IDENTIFIER );
  }

  /**
   * All classes which extend \Model\Base must have a way to determine the private key,
   * either through hard-coding or a method, doesn't matter as long as we have one
   */
  abstract function getPrimaryKey( );
}
