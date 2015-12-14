<?php

namespace View;


class WebScrapeView{

    private $movies;

    public function __construct($movies){
        $this->movies = $movies;
    }

    public function getResponse(){
        $html = "<h1> Följande filmer hittades</h1>";
        $html.= "<ul>";

        foreach($this->movies as $movie){

            $html.="<li>
            Filmen ". $movie->getMovieName() . " klockan " . $movie->getTime() . " på " . $movie->getDay() . " . Följande tider finns tillgängliga på Zekes resturang";

            $html.="ul";

            if(empty($movie->getAvaliableTimes())){
                $html.= "<li>  Fanns inga tider </li>";
            }
            else{
                foreach($movie->getAvaliableTimes() as $time){
                    $html.= "<li>" . $time . "</li>";
                }
            }
                $html.= "</ul></li>";
        }
            return $html;
    }
}