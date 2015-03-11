<?php
/**
 *
 *
 *
 *
 *
 *
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

  public function getPrimaryKey( )
  {
    return $this->pk;
  }

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
