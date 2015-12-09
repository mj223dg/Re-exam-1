<?php

namespace models;

class WebScraper{


    private $frontPageCalendar = '//div[@class="col s12 center"]//li/a';

    private $frontPage = "//li/a";

    private $calendarTbody = '//table//tbody//tr//td';

    private $calendarThead = '//table//thead//tr//th';

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
            die("Fel vid inläsning av första länkarna");
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
        die("Fel vid inläsning av kalendern");
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
            die("Fel vid inläsning av biografen");
        }
    }
    */


    public function ScrapeCalendarDays($href) {
        $data = $this->curl_get_request($this->baseUrl . $href);

        $dom = new \DomDocument();

        $calendarDays = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $ok = $xpath->query($this->calendarTbody);
            $days = $xpath->query($this->calendarThead);


            for ($i = 0; $i < $days->length; $i++) {

                $calendarDays[strtolower($days->item($i)->nodeValue)] = strtolower($ok->item($i)->nodeValue);
            }

            return $calendarDays;

        }
        else{
            die("Fel vid inläsning av dagarna");
        }
    }

    public function CombineDays(){
        $arr = array();
        $arr[] = $this->ScrapeCalendarDays("/calendar/peter.html");
        $arr[] = $this->ScrapeCalendarDays("/calendar/mary.html");
        $arr[] = $this->ScrapeCalendarDays("/calendar/paul.html");
        $days = call_user_func_array('array_intersect_assoc', $arr);

        var_dump($days);



    }

    public function curl_get_request($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);

        //Vad som ska hämtas
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


        // Exekvera anropet
        $data = curl_exec($ch);

        // Stäng cUrl resurs
        curl_close($ch);

        // Skriv ut och se vad vi har fått

        return $data;
    }

    private function EngToSwe($days){
        switch(strtolower($days)){
            case "friday":
                return "Fredag";
            case "saturday":
                return "Lördag";
            case "sunday":
                return "Söndag";
        }
    }

}


?>