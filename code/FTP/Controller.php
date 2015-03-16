<?php
/**
 * FTP\Controller is a reference class to demonstrate retrieving FTP credentials
 *
 * @package NeatstuffReference
 * @subpackage FTP
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 2015-03-15
 */

namespace FTP;

use \Data\Configuration;

class Controller
{
  /**
   * FTP Publish keys, including PORT, which we don't use here in this application
   */
  const FTP_KEY_PUBLISH_HOST = 'publish_host';
  const FTP_KEY_PUBLISH_PORT = 'publish_port';
  const FTP_KEY_PUBLISH_USERNAME = 'publish_username';
  const FTP_KEY_PUBLISH_PASSWORD = 'publish_password';
  const FTP_KEY_PUBLISH_PATH = 'publish_path';

  /**
   * With the given user details, send an API request to Weebly to set generated FTP credentials
   *
   * @param object $user
   * @param array $weeblySiteId
   *
   * @return bool
   * @throws \Exception
   */
  public static function setWeeblyFTPCredentials( $user, $weeblySiteId )
  {
    $credentials = array(
      'publish_host' => self::getFTPCredential( $user, self::FTP_KEY_PUBLISH_HOST ),
      'publish_username' => self::getFTPCredential( $user, self:: FTP_KEY_PUBLISH_USERNAME ),
      'publish_password' => self::getFTPCredential( $user, self::FTP_KEY_PUBLISH_PASSWORD ),
      'publish_path' => self::getFTPCredential( $user, self::FTP_KEY_PUBLISH_PATH )
    );

    $request = \Weebly\APIClient::post(
      'user/' . $user->weebly_user . '/site/' . $weeblySiteId . '/setPublishCredentials',
      $credentials
    );

    if ( isset( $request['error'] ) === true ) {
      throw new \Exception( $request['error']['message'] );
    }

    return true;
  }

  /**
   * Retrieves the given FTP credential for the given user
   *
   * @param object $user
   * @param string $key
   *
   * @return mixed
   */
  private static function getFTPCredential( $user, $key )
  {
    if ( Configuration::FTP_CREDENTIAL_MODE === 'constants' )
    {
      switch ( $key )
      {
        case self::FTP_KEY_PUBLISH_HOST:
          $value = Configuration::FTP_HOST;
          break;

        case self::FTP_KEY_PUBLISH_USERNAME:
          $value = Configuration::FTP_USER;
          break;

        case self::FTP_KEY_PUBLISH_PASSWORD:
          $value = Configuration::FTP_PASSWORD;
          break;

        case self::FTP_KEY_PUBLISH_PATH:
          $value = Configuration::FTP_PATH_PREFIX . $user->subdomain;
          break;
      }
    }

    /**
     * Else, you could have a separate model, extend User, or something
     * $user->ftp_username, etc..
     */
    return $value;
  }
}