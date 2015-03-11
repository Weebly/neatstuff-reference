<?php
/**
 * User\Controller controls methods associated with user actions
 *
 * @package NeatstuffReference
 * @subpackage User
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
namespace User;

use \Model\Theme;
use \Model\User;
use \API\Exception;
use \Data\Configuration;

class Controller
{
  /**
   * Users may not create subdomains on any of these locations
   * @var $invalidSubdomains
   */
  private static $invalidSubdomains = array(
    'test',
    'www',
    'store',
    'staging',
    'themes',
    'production'
  );

  /**
   * Attempts to create a new user with the given payload, which must contain
   * 'email' => string
   * 'password' => string
   * 'subdomain' => string
   *
   * This is a method exposed to the API\Endpoint class
   *
   * @return array
   * @throws \API\Exception
   */
  public static function create( $payload )
  {
		self::createUser( $payload['email'], $payload['password'], $payload['subdomain'] );

		$user = self::doesUserExist( $payload['email'] );
  /**
   * oops.
   */
  if ( $user === false ) {
			throw new \API\Exception( 'Error creating user' );
		}

    self::createWeeblyAccount( $user );
    self::createWeeblySite( $user, $payload['theme_id'] );
    self::createUserDirectory( $user );

    return array(
      'success' => true,
      'message' => self::getWeeblyLoginLink( $user )
    );
  }

  /**
   * Attempts to create a new user with the given credentials
   *
   * @param string $email
   * @param string $password
   * @param string $subdomain
   *
   * @return bool
   * @throws \API\Exception
   */
  public static function createUser( $email, $password, $subdomain )
  {
    if ( isset( $email ) === false || isset( $password ) === false || isset( $subdomain ) === false ) {
      throw new \API\Exception( 'Invalid parameters were passed to create a user' );
    }

    $subdomain = self::validateSubdomain( $subdomain );

    if ( self::doesUserExist( $email ) !== false ) {
			throw new \API\Exception( 'Cannot recreate existing user' );
    }
    if ( self::doesUserExist( $subdomain ) !== false ) {
      throw new \API\Exception( 'Subdomain already exists' );
    }

    $model = new User( );
    $model->email = $email;
    try
    {
      $model->password = $model->generatePasswordHash( $password );
    }
    catch ( \Exception $e )
    {
      throw new \API\Exception( $e->getMessage( ) );
    }
    $model->subdomain = $subdomain;

    return $model->save( );
  }

  /**
   * Creates a new Weebly account with the given NeatStuff userId
   * Saves the returned Weebly userId in the User model
   *
   * @param int $userId
   *
   * @return void
   * @throws \API\Exception
   */
  public static function createWeeblyAccount( $userId )
  {
    $user = new User( $userId );
    if ( $user->user_id === NULL ) {
      throw new \API\Exception( 'Could not find user ' . $userId );
    }

    $result = \Weebly\APIClient::post(
      'user',
      array(
        'email' => $user->email
      )
    );

    if ( isset( $result['error'] ) === true ) {
      throw new \API\Exception( 'Error creating account ' . $result['error']['message'] );
    }

    $user->weebly_user = $result['user']['user_id'];
    $user->save( );
  }

  /**
   * Creates a new Weebly site with the given NeatStuff userId, themeId
   *
   * @param int $userId
   * @param int $themeId
   *
   * @return void
   * @throws \API\Exception
   */
  public static function createWeeblySite( $userId, $themeId )
  {
    $user = new User( $userId );
    if ( $user->user_id === NULL ) {
      throw new \API\Exception( 'Could not find user ' . $userId );
    }

    $theme = new Theme( $themeId );
    if ( $theme->theme_id === NULL ) {
      throw new \API\Exception( 'Could not find theme ' . $themeId );
    }

    $site = \Weebly\APIClient::post(
      'user/' . $user->weebly_user . '/site',
      array(
        'domain' => $user->subdomain . Configuration::BRAND_DOMAIN,
        'site_title' => $theme->name
      )
    );

    if ( isset( $site['error'] ) === true ) {
      throw new \API\Exception( 'Error creating site ' . $site['error']['message'] );
    }

    $credentials = \Weebly\APIClient::post(
      'user/' . $user->weebly_user . '/site/' . $site['site']['site_id'] . '/setPublishCredentials',
      array(
        'publish_host' => Configuration::FTP_HOST,
        'publish_username' => Configuration::FTP_USER,
        'publish_password' => Configuration::FTP_PASSWORD,
        'publish_path' => Configuration::FTP_PATH_PREFIX . $user->subdomain
      )
    );

    if ( isset( $credentials['error'] ) === true ) {
      throw new \API\Exception( 'Error setting credentials ' . $credentials['error']['message'] );
    }

    $themeFile = Configuration::THEME_HOST . strtolower( preg_replace( "/[^a-z]/i", '', $theme->name ) ) . '.zip';
    $themeCreate = \Weebly\APIClient::post(
      'user/' . $user->weebly_user . '/theme',
      array(
        'theme_name' => $theme->name,
        'theme_zip' => $themeFile
      )
    );

    if ( isset( $themeCreate['error'] ) === true ) {
      throw new \API\Exception( 'Could not upload theme ' . $themeCreate['error']['message'] );
    }

    $themeSet = \Weebly\APIClient::post(
      'user/' . $user->weebly_user . '/site/' . $site['site']['site_id'] . '/theme',
      array(
        'theme_id' => $themeCreate['theme_id'],
        /**
         * todo default to this for now
         */
        'is_custom' => true
      )
    );

    if ( isset( $themeSet['error'] ) === true ) {
      throw new \API\Exception( 'Could not set theme ' . $themeSet['error']['message'] );
    }
  }

  /**
   * Retrieves the Weebly login link for the given NeatStuff userId
   *
   * @param int $userId
   *
   * @return string
   * @throws \API\Exception
   */
  private static function getWeeblyLoginLink( $userId )
  {
    $user = new User( $userId );
    if ( $user->user_id === NULL ) {
      throw new \API\Exception( 'Could not find user ' . $userId );
    }

    $link = \Weebly\APIClient::post(
      'user/' . $user->weebly_user . '/loginLink',
      ''
    );

    if ( isset( $link['error'] ) === true ) {
      throw new \API\Exception( 'Could not create login link ' . $link['error']['message'] );
    }

    return $link['link'];
  }

  /**
   * Creates a new local publish directory for the given NeatStuff userId
   *
   * @param int $userId
   *
   * @return void
   * @throws \API\Exception
   */
  private static function createUserDirectory( $userId )
  {
    $user = new User( $userId );
    if ( $user->user_id === NULL ) {
      throw new \API\Exception( 'Could not find user ' . $userId );
    }

    if ( mkdir( Configuration::FTP_PATH_PREFIX . $user->subdomain, 0777 ) !== true ) {
      throw new \API\Exception( 'Could not create new directory for user' );
    }

    chmod( Configuration::FTP_PATH_PREFIX . $user->subdomain, 0777 );
  }

  /**
   * Validates, normalizes, the given subdomain
   *
   * @param string $subdomain
   *
   * @return string
   * @throws \API\Exception
   */
  private static function validateSubdomain( $subdomain )
  {
    if ( in_array( $subdomain, self::$invalidSubdomains ) === true ) {
      throw new \API\Exception( 'Invalid subdomain' );
    }

    return strtolower( preg_replace( "/[^a-z0-9]/i", '', $subdomain ) );
  }

  /**
   * Determines whether a user exists based on the given primary key
   *
   * @param mixed $key
   *
   * @return bool|int
   */
  private static function doesUserExist( $key )
  {
    $model = new User( $key );
    if ( $model->user_id === NULL ) {
      return false;
    }

    return $model->user_id;
  }

  /**
   * Authenticates the given NeatStuff credentials, in payload, and creates a Weebly login link
   *
   * @param array $payload
   *
   * @return array
   * @throws \API\Exception
   */
  public static function login( $payload )
  {
    $user = new User( $payload['email'] );
    if ( $user->user_id === NULL ) {
        throw new \API\Exception( 'Username or password failure' );
    }

    if ( $user->validatePassword( $payload['password'] ) === true ) {
      return array(
        'success' => true,
        'message' => self::getWeeblyLoginLink( $user->user_id )
      );
    }

    throw new \API\Exception( 'Username or password failure' );
  }
}
