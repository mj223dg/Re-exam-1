<?php

namespace models;

class WebScraper{


    private $frontPageCalendar = '//div[@class="col s12 center"]//li/a';

    private $frontPage = "//li/a";

    private $calendarTbody = '//table[@class="striped centered responsive-table"]/tbody/tr//td';

    private $calendarThead = '//table[@class="striped centered responsive-table"]/thead/tr//th';

    private $calendarMaryTbody = '//table[@class="centered striped responsive-table"]/tbody/tr//td';

    private $calendarMaryThead = '//table[@class="centered striped responsive-table"]/thead/tr//th';

    private $baseUrl = 'localhost:8080';

    //private $arrayOfAvailableDays = array();


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

    public function test(){
        $this->ScrapePaulsDays($this->linksPaulsCalendarDays);
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
    /*
    public function ScrapeCinema() {

        $data = $this->curl_get_request($this->baseUrl ."/cinema/");

        $dom = new \DomDocument();

        $linksCinema = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($this->frontPageCalendar);

            foreach($items as $item){
                var_dump($item->getAttribute("href"));
                $linksCinema[] = $items;
            }
        }
        else{
            die("Fel vid inl�sning av biografen");
        }
    }
    */

    private function EngToSwe($day){
        switch($day){
            case "friday":
                return "Fredag";
            case "saturday":
                return "L�rdag";
            case "sunday":
                return "S�ndag";
        }
    }

    public function ScrapePaulsDays() {
        $data = $this->curl_get_request($this->baseUrl ."/calendar/paul.html");

        $dom = new \DomDocument();

        $linksPaulsCalendarDays = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $days = $xpath->query($this->calendarThead);
            $Ok = $xpath->query($this->calendarTbody);

            for ($i = 0; $i < $days->length; $i++) {
                $linksPaulsCalendarDays[$days[$i]->nodeValue] = $Ok[$i]->nodeValue;
            }

            return $linksPaulsCalendarDays;
        }
        else{
            die("Fel vid inl�sning av Pauls dagar");
        }
    }


        public function ScrapePetersDays() {
            $data = $this->curl_get_request($this->baseUrl ."/calendar/peter.html");

            $dom = new \DomDocument();

            $linksPetersCalendarDays = array();

            if($dom->loadHTML($data)){

                $xpath = new \DOMXPath($dom);
                $days = $xpath->query($this->calendarThead);
                $Ok = $xpath->query($this->calendarTbody);

                for ($i = 0; $i < $days->length; $i++) {
                    $linksPetersCalendarDays[$days[$i]->nodeValue] = $Ok[$i]->nodeValue;
                }

                return $linksPetersCalendarDays;

            }
            else{
                die("Fel vid inl�sning av Peters dagar");
            }
        }


    public function ScrapeMarysDays() {
        $data = $this->curl_get_request($this->baseUrl ."/calendar/mary.html");

        $dom = new \DomDocument();

        $linksMarysCalendarDays = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $days = $xpath->query($this->calendarMaryTbody);
            $ok = $xpath->query($this->calendarMaryThead);

            for ($i = 0; $i < $days->length; $i++) {
                $linksMarysCalendarDays[$days[$i]->nodeValue] = $ok[$i]->nodeValue;
            }
            return $linksMarysCalendarDays;

        }
        else{
            die("Fel vid inl�sning av Marys dagar");
        }
    }

    /*
    public function CheckDays(){
        if($this->ScrapePaulOk() && $this->ScrapeMaryOk() && $this->ScrapePeterOk()){

        }
    }
    */

    public function CombineDays(){
        $arr = array();
        $arr[] = $this->ScrapeMarysDays();
        $arr[] = $this->ScrapePaulsDays();
        $arr[] = $this->ScrapePetersDays();
        $days = call_user_func_array('array_intersect_assoc', $arr);

        var_dump($days);

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