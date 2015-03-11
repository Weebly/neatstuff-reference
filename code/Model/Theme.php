<?php
/**
 * Theme Model
 **/
namespace Model;

use \Model\Base;
use \Data\PostgreSQL;

class Theme extends Base
{
	public $theme_id;
	public $name;
	public $price;
	public $tags;
  public $table = 'themes';
	
	public function getPrimaryKey()
	{
		return "theme_id";
	}
	
	public function getTagArray()
	{
		return explode(",", $this->tags);
	}
	
	public function getScreenshotUrl()
	{
		return "/themes/" . self::nameToFile($this->name) . ".png";
	}
	
	/**
	 * Returns a relative url to the theme's zip file.
	 **/
	public function getZipUrl()
	{
		return "/themes/" . self::nameToFile($this->name) . ".zip";
	}
	
	/**
	 * Converts a theme name to a filename. Used
	 * for zips and images.
	 **/
	public static function nameToFile($name)
	{
		$file = strtolower($name);
		$file = preg_replace("/\s/", "_", $file);
		$file = preg_replace("/[^a-z0-9\.]/", "", $file);
		return $file;
	}
	
	/**
	 * Loads all theme models
	 **/
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
	 * Deletes all the themes in the db.
	 **/
	public static function deleteAllThemes()
	{
		$db = PostgreSQL::getInstance(PostgreSQL::DEFAULT_IDENTIFIER);
		$db->query("DELETE FROM themes");
	}
}