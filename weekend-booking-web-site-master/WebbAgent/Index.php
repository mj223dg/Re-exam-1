<?php

require_once("Views/LayoutView.php");
require_once("Models/WebScraper.php");
require_once("Controllers/TestController.php");

error_reporting(-1);
ini_set('display_errors', 1);

$mjö = new \models\WebScraper();

$mjö->scrape();





