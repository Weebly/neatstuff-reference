<?php
/**
 * Model\Theme handles all Theme Models
 *
 * @package NeatstuffReference
 * @subpackage Model
 * @author Drew Richards <drew@weebly.com>
 * @since 
 */
namespace Model;

use \Data\PostgreSQL;

class Theme extends Base
{
	public $theme_id;
	public $name;
	public $price;
	public $tags;
	public $table = 'themes';

	/**
	 * Retreives the Primary Key for this model
	 *
	 * @return string
	 */
	public function getPrimaryKey()
	{
		return "theme_id";
	}
	
	/**
	 * Retreives the tag array for this model
	 *
	 * @return array
	 */
	public function getTagArray()
	{
		return explode(",", $this->tags);
	}

	/**
	 * Retreives the screenshot URL for this model
	 *
	 * @return string
	 */
	public function getScreenshotUrl()
	{
		return "/themes/" . self::nameToFile($this->name) . ".png";
	}
	
	/**
	 * Returns a relative url to the theme's zip file
	 *
	 * @return string
	 */
	public function getZipUrl()
	{
		return "/themes/" . self::nameToFile($this->name) . ".zip";
	}
	
	/**
	 * Converts a theme name to a filename, which is used for zips and images.
	 *
	 * @return string
	 */
	public static function nameToFile($name)
	{
		$file = strtolower($name);
		$file = preg_replace("/\s/", "_", $file);
		$file = preg_replace("/[^a-z0-9\.]/", "", $file);
		return $file;
	}
	
	/**
	 * Loads all theme models
	 * Since the goofy ORM doesn't have a getMultiple method, or support CRUD operations on multiple models
	 *
	 * @return array
	 */
	public static function findAll()
	{
		$db = PostgreSQL::getInstance(PostgreSQL::DEFAULT_IDENTIFIER);
		$result = $db->query("SELECT * FROM " . Base::SCHEMA . "themes");
		
		$themes = array();
		foreach ($result->fetchAll() as $t) {
			$theme = new Theme();
			foreach ($t as $key => $value) {
				$theme->$key = $value;
			}
			$themes[] = $theme;
		}
		return $themes;
	}
	
	/**
	 * Deletes all the themes in the db
	 *
	 * @return void
	 */
	public static function deleteAllThemes()
	{
		$db = PostgreSQL::getInstance(PostgreSQL::DEFAULT_IDENTIFIER);
		$db->query("DELETE FROM themes");
	}
}
