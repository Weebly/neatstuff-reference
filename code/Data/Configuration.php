<?php
/**
 * Data\Configuration handles all strings and values associated with running the reference project
 *
 * @package NeatstuffReference
 * @subpackage Data
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
namespace Data;

class Configuration
{
  const POSTGRES_USER_DSN = 'pgsql:host=localhost;port=5432;dbname=neatstuff;user=YOUR_USER;password=YOUR_PASSWORD';

  const WEEBLY_PUBLIC_KEY = 'YOUR_WEEBLY_PUBLIC_KEY';
  const WEEBLY_PRIVATE_KEY = 'YOUR_WEEBLY_PRIVATE_KEY';
  const WEEBLY_ENDPOINT = 'https://api.weeblycloud.com/hosts/';
  const WEEBLY_HMAC_HASH_STRATEGY = 'SHA256';

  const BRAND_DOMAIN = 'YOUR_BRAND_DOMAIN.COM';
  const BRAND = 'YOUR_BRAND';

  const FTP_CREDENTIAL_MODE = 'constants';
  const FTP_HOST = 'YOUR_FTP_HOST';
  const FTP_USER = 'YOUR_FTP_USER';
  const FTP_PASSWORD = 'YOUR_FTP_PASSWORD';
  const FTP_PATH_PREFIX = 'YOUR_FTP_PATH_PREFIX';

  const THEME_HOST = 'HTTP://YOUR_URL_TO_THEME_HOST.COM';

  const USER_PASSWORD_COST = 10;

  /**
   * Maps PostgreSQL instances to DSN strings in this class
   * @var $postgresql
   */
  public static $postgresql = array(
    PostgreSQL::USER_DATA_IDENTIFIER => self::POSTGRES_USER_DSN
  );
}
