<?php

require_once("Views/LayoutView.php");
require_once("Models/WebScraper.php");
require_once("Controllers/TestController.php");

error_reporting(-1);
ini_set('display_errors', 1);

//$mje = new \Models\WebScraper();
//$mje->webScrape();

//$mjo = new \models\WebScraper();
//$mjo->ScrapeCalendar();

$mjö = new \models\WebScraper();
$mjö->ScrapePaulOk();

//$LayoutView = new \Views\LayoutView("utf-8");
//echo $LayoutView ->Layout("häst","<h1>katt</h1>");

//test git user.email shit








