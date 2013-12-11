#!/usr/bin/php
<?php
define('ROOT',      dirname(__FILE__));
require_once(ROOT . '/Pattern.class.php');
require_once(ROOT . '/Path.class.php');
require_once(ROOT . '/Match.class.php');

// create Match object to handle the input
$match = new Match();
$match->process();

