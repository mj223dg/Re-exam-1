<?php
/**
 * Created by PhpStorm.
 * User: Mattias
 * Date: 2015-12-12
 * Time: 21:44
 */

namespace models;


class MovieSuggestion
{
    public  $day;

    public $time;

    public $movieName;


    public function  __construct($day, $time, $movieName){
        $this->day = $day;
        $this->time = $time;
        $this->movieName = $movieName;
    }
}