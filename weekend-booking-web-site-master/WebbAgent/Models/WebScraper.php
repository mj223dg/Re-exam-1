<?php

namespace models;

class WebScraper{


   //private $frontPageCalendar = '//div[@class="col s12 center"]//li/a';

    //private $frontPage = "//li/a";

    private $calendarTbody = '//table//tbody//tr//td';

    private $calendarThead = '//table//thead//tr//th';

    private $dayQuery = '//select[@id="day"]/option[not(@disabled)]';

    private $movieQuery = '//select[@id="movie"]/option[not(@disabled)]';

    private $baseUrl = 'localhost:8080';

    private $arrayOfAvailableDays = array();

    private $moveSuggestion = array();

    private $day;

    private $movieName;

    private $time;

    public function scrape() {
        $this->scrapeCalendars();
        $this->scrapeMovieSuggestions("/cinema");
    }



    public function scrapeCalendarDays($href) {
        $data = $this->curl_get_request($this->baseUrl . $href);

        $dom = new \DomDocument();

        $calendarDays = array();

        if($dom->loadHTML($data)){

            $xpath = new \DOMXPath($dom);
            $ok = $xpath->query($this->calendarTbody);
            $days = $xpath->query($this->calendarThead);


            for ($i = 0; $i < $days->length; $i++) {

                $calendarDays[$this->EngToSwe(strtolower($days->item($i)->nodeValue))] = strtolower($ok->item($i)->nodeValue);
            }

            return $calendarDays;

        }
        else{
            die("Fel vid inläsning av dagarna");
        }
    }

    public function scrapeMovieSuggestions($href){
        $data = $this->curl_get_request($this->baseUrl . $href);

        $dom = new \DOMDocument();

        if($dom->loadHTML($data)){

            $domXpatch = new \DOMXPath($dom);

            $days = $domXpatch->query($this->dayQuery);
            $movie = $domXpatch->query($this->movieQuery);

            foreach($days as $dayOpt){
                foreach($movie as $movieOpt){
                    foreach($this->arrayOfAvailableDays as $day => $value){

                        if($day === $dayOpt->nodeValue){

                            $json = $this->curl_get_request($this->baseUrl."/cinema/check?day=" . $dayOpt->getAttribute('value') . "&movie=" . $movieOpt->getAttribute('value'));
                            $jsonCode = json_decode($json, true);

                            foreach($jsonCode as $moviesJson){
                                if($moviesJson->status === 1){

                                    $this->moveSuggestion[] = new
                                }
                            }

                        }
                    }
                }
            }
        }

    }

    public function scrapeCalendars(){
        $arr = array();
        $arr[] = $this->scrapeCalendarDays("/calendar/peter.html");
        $arr[] = $this->scrapeCalendarDays("/calendar/mary.html");
        $arr[] = $this->scrapeCalendarDays("/calendar/paul.html");
        $this->arrayOfAvailableDays = call_user_func_array('array_intersect_assoc', $arr);


    }

    public function curl_get_request($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);

        //Vad som ska hämtas
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


        // Exekvera anropet
        $data = curl_exec($ch);

        // St�ng cUrl resurs
        curl_close($ch);

        // Skriv ut och se vad vi har f�tt

        return $data;
    }

    private function EngToSwe($days){
        switch($days){
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