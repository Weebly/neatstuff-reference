<?php
/**
 * Model\User is our the model that represents a User on NeatStuff
 *
 * @package NeatstuffReference
 * @subpackage Model
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
namespace Model;

use \Data\Configuration;

class User extends Base
{
  /**
   * Multiple primary key options here, because we may want to lookup a model based on any of them
   */
  const DEFAULT_PRIMARY_KEY = 'user_id';
  const SECONDARY_PRIMARY_KEY = 'email';
  const TERTIARY_PRIMARY_KEY = 'subdomain';

  public $user_id;
  public $email;
  public $password;
  public $subdomain;

  protected $pk = 'user_id';

  /**
   * Returns the current primary key for this model
   *
   * @return string
   */
  public function getPrimaryKey( )
  {
    return $this->pk;
  }

  /**
   * Constructor, creates a model based on the given primary key value
   *
   * @param mixed $pkValue
   *
   * @return object
   * @throws \Exception
   */
  public function __construct( $pkValue = NULL )
  {
    if ( is_numeric( $pkValue ) === true ) {
      $this->pk = self::DEFAULT_PRIMARY_KEY;
    } elseif ( stripos( $pkValue, '@' ) !== false ) {
      $this->pk = self::SECONDARY_PRIMARY_KEY;
    } elseif ( is_string( $pkValue ) === true ) {
      $this->pk = self::TERTIARY_PRIMARY_KEY;
    }

    parent::__construct( $pkValue );
  }

  /**
   * Generates a password hash with the given plaintext password
   *
   * @param string $password
   *
   * @return string
   * @throws \Exception
   */
  public function generatePasswordHash( $password )
  {
    if ( isset( $password{4} ) === false ) {
      throw new \Exception( 'The supplied password was too short to hash' );
    }

    return \password_hash(
      $password,
      \PASSWORD_BCRYPT,
      array(
        'cost' => Configuration::USER_PASSWORD_COST
      )
    );
  }

  /**
   * Validates that the given plaintext password hashes to the current model's password hash
   *
   * @param string $password
   *
   * @return bool
   */
  public function validatePassword( $password )
  {
    if ( isset( $password ) === false ) {
      return false;
    }

    if ( \password_verify( $password, $this->password ) === true ) {
      return true;
    }

    return false;
  }
}
