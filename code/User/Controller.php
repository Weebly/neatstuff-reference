<?php
/**
 *
 *
 *
 *
 *
 *
 */
namespace User;

use \Model\Theme;
use \Model\User;
use \API\Exception;
use \Data\Configuration;

class Controller
{
  /**
   *
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
   *
   */
	public static function create( $payload )
	{
		self::createUser( $payload['email'], $payload['password'], $payload['subdomain'] );

		$user = self::doesUserExist( $payload['email'] );
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
   *
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

    $model = new \Model\User( );
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
   *
   */
  public static function createWeeblyAccount( $userId )
  {
    $user = new \Model\User( $userId );
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
   *
   *
   */
  public static function createWeeblySite( $userId, $themeId )
  {
    $user = new \Model\User( $userId );
    if ( $user->user_id === NULL ) {
      throw new \API\Exception( 'Could not find user ' . $userId );
    }

    $theme = new \Model\Theme( $themeId );
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
   *
   */
  private static function getWeeblyLoginLink( $userId )
  {
    $user = new \Model\User( $userId );
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
   *
   */
  private static function createUserDirectory( $userId )
  {
    $user = new \Model\User( $userId );
    if ( $user->user_id === NULL ) {
      throw new \API\Exception( 'Could not find user ' . $userId );
    }

    if ( mkdir( Configuration::FTP_PATH_PREFIX . $user->subdomain, 0777 ) !== true ) {
      throw new \API\Exception( 'Could not create new directory for user' );
    }

    chmod( Configuration::FTP_PATH_PREFIX . $user->subdomain, 0777 );
  }

  /**
   *
   */
  private static function validateSubdomain( $subdomain )
  {
    if ( in_array( $subdomain, self::$invalidSubdomains ) === true ) {
      throw new \API\Exception( 'Invalid subdomain' );
    }

    return strtolower( preg_replace( "/[^a-z0-9]/i", '', $subdomain ) );
  }

  /**
   *
   */
  private static function doesUserExist( $key )
  {
    $model = new \Model\User( $key );
    if ( $model->user_id === NULL ) {
      return false;
    }

    return $model->user_id;
  }

  /**
   *
   *
   *
   *
   */
  public static function login( $payload )
  {
    $user = new \Model\User( $payload['email'] );
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
