<?php

require_once("Views/LayoutView.php");
require_once("Models/WebScraper.php");
require_once("Controllers/TestController.php");

error_reporting(-1);
ini_set('display_errors', 1);

$mj� = new \models\WebScraper();

$mj�->scrape();





