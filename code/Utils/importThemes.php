<?php

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
 * Randomly assigns tags to a theme.
 **/
function getTags()
{
	return getRandomValues($GLOBALS['tags']);
}

/**
 * Randomly gets a price.
 **/
function getPrice() {
	$prices = $GLOBALS['prices'];
	$key = array_rand($prices);
	return $prices[$key];
}

/**
 * Gets random values from an array and concatenates them with a ,
 **/
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