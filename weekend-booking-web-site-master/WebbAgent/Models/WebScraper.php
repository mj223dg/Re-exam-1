<?php

namespace models;

class WebScraper{


    private $frontPageCalendar = '//div[@class="col s12 center"]//li/a';

    private $frontPage = "//li/a";


    private $baseUrl = 'localhost:8080';

    public function webScrape() {

        $data = $this->curl_get_request($this->baseUrl);

        $dom = new \DomDocument();

        $linksFrontPage = array();

        if($dom->loadHTML($data)) {
            $xpath = new \DOMXPath($dom);

            $items = $xpath->query($this->frontPage);

            foreach ($items as $item) {
                var_dump($item->getAttribute("href"));
                $linksFrontPage[] = $items;
            }


        }
        else {
            die("Fel vid inl�sning av f�rsta l�nkarna");
        }

    }

    public function ScrapeCalendar() {

        $data = $this->curl_get_request($this->baseUrl ."/calendar/");

        $dom = new \DomDocument();

        $linksCalendar = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($this->frontPageCalendar);

            foreach($items as $item){
                var_dump($item->getAttribute("href"));
                $linksCalendar[] = $items;
            }
        }
        else{
            die("Fel vid inl�sning av kalendern");
        }
    }

    private $calendarThead = '//table[@class="striped centered responsive-table"]/thead/tr//th';
    public function ScrapePaulDays() {
        $data = $this->curl_get_request($this->baseUrl ."/calendar/paul.html");

        $dom = new \DomDocument();

        $linksPaulCalendarDays = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($this->calendarThead);

            foreach($items as $item){
                var_dump($item->nodeValue);
                $linksPaulCalendarDays[] = $items;
            }
        }
        else{
            die("Fel vid inl�sning av Pauls dagar");
        }

    }



    private $calendarTbody = '//table[@class="striped centered responsive-table"]/tbody/tr//td';
    public function ScrapePaulOk(){
        $data = $this->curl_get_request($this->baseUrl . "/calendar/paul.html");

        $dom = new \DomDocument();

        $linksPaulCalendarOk = array();

        if ($dom->loadHTML($data)) {

            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($this->calendarTbody);

            foreach ($items as $item) {
                var_dump($item->nodeValue);
                $linksPaulCalendarOk[] = $items;
            }
        }
        else {
            die("Fel vid inl�sning av Pauls dagar");
        }
    }

    public function ScrapePetersDays() {
        $data = $this->curl_get_request($this->baseUrl ."/calendar/peter.html");

        $dom = new \DomDocument();

        $linksPeterCalendarDays = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($this->calendarThead);

            foreach($items as $item){
                var_dump($item->nodeValue);
                $linksPeterCalendarDays[] = $items;
            }
        }
        else{
            die("Fel vid inl�sning av Peters dagar");
        }

    }

    public function ScrapePeterOk(){
        $data = $this->curl_get_request($this->baseUrl . "/calendar/paul.html");

        $dom = new \DomDocument();

        $linksPeterCalendarOk = array();

        if ($dom->loadHTML($data)) {

            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($this->calendarTbody);

            foreach ($items as $item) {
                var_dump($item->nodeValue);
                $linksPeterCalendarOk[] = $items;
            }
        }
        else {
            die("Fel vid inl�sning av Peters dagar");
        }
    }

    public function ScrapeMarysDays() {
        $data = $this->curl_get_request($this->baseUrl ."/calendar/peter.html");

        $dom = new \DomDocument();

        $linksMarysCalendarDays = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($this->calendarThead);

            foreach($items as $item){
                var_dump($item->nodeValue);
                $linksMarysCalendarDays[] = $items;
            }
        }
        else{
            die("Fel vid inl�sning av Marys dagar");
        }

    }

    public function ScrapeMaryOk(){
        $data = $this->curl_get_request($this->baseUrl . "/calendar/paul.html");

        $dom = new \DomDocument();

        $linksMarysCalendarOk = array();

        if ($dom->loadHTML($data)) {

            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($this->calendarTbody);

            foreach ($items as $item) {
                var_dump($item->nodeValue);
                $linksMarysCalendarOk[] = $items;
            }
        }
        else {
            die("Fel vid inl�sning av Marys dagar");
        }
    }

    public function curl_get_request($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);

        //Vad som ska h�mtas
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


        // Exekvera anropet
        $data = curl_exec($ch);

        // St�ng cUrl resurs
        curl_close($ch);

        // Skriv ut och se vad vi har f�tt

        return $data;
    }
}


?>