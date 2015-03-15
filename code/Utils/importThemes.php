<?php
/**
 * Imports theme files in the `code/Utils/BaseTemplates` directory
 * As a reference release, the BaseTemplates directory contains a basic Weebly theme
 * The two methods to get theme metadata just get random values right now, but you can edit these
 * to support your implementation.
 *
 * Usage for this file is `php ./importThemes.php`.
 *
 * @package NeatstuffReference
 * @subpackage Util
 * @author Drew Richards <drew@weebly.com>
 * @since 
 */

require_once(__DIR__ . "/../../bootstrap/Init.php");

$baseTemplateDir = __DIR__ . "/BaseTemplates";
$finalTemplateDir = __DIR__ . "/../../themes";

$tags = array("Bold", "Corporate", "Fun", "Simple", "Sleek");
$prices = array(8.95, 19.99, 49.75);

\Model\Theme::deleteAllThemes();

foreach (new DirectoryIterator($baseTemplateDir) as $file) {
  if ($file->isDot()) {
    continue;
  }

  $filename = \Model\Theme::nameToFile($file->getFilename());
  copy($file->getPathname(), $finalTemplateDir ."/" . $filename);
  if (preg_match("/\.zip$/", $file->getFilename())) {
    $theme = new \Model\Theme();
    $theme->name = preg_replace("/\.zip/", "", $file->getFilename());
    $theme->tags = getTags();
    $theme->price = getPrice();
    $theme->save();
  }
}

/**
 * Randomly returns values from the "tags" array above
 *
 * @return string
 */
function getTags()
{
  return getRandomValues($GLOBALS['tags']);
}

/**
 * Randomly returns a value from the "prices" array above
 *
 * @return flaot
 */
function getPrice() {
  $prices = $GLOBALS['prices'];
  $key = array_rand($prices);
  return $prices[$key];
}

/**
 * Gets random values from the given array and concatenates them with a ,
 *
 * @return string
 */
function getRandomValues($array)
{
  $numValues = rand(1, count($array));
  $keys = array_rand($array, $numValues);
  $keys = is_array($keys) ? $keys : array($keys);
  $values = array();
  foreach ($keys as $k) {
    $values[] = $array[$k];
  }
  return implode(",", $values);
}