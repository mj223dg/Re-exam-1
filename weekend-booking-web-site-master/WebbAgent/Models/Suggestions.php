<?php
/**
 * Created by PhpStorm.
 * User: Mattias
 * Date: 2015-12-12
 * Time: 21:44
 */

namespace models;


class Suggestions
{
    private  $day;

    private $time;

    private $movieName;

    private $avaliableTimes = array();

    public function  __construct($day, $time, $movieName){
        $this->day = $day;
        $this->time = $time;
        $this->movieName = $movieName;
    }

    public function getDay(){
        return $this->day;
    }

    public function getTime(){
        return $this->time;
    }

    public function getMovieName(){
        $this->movieName;
    }

    public function getAvaliableTimes(){
        return  $this->avaliableTimes;
    }

    public function addAvaliableTime($time){
        $this->avaliableTimes[] = date("H:i", $time);
    }

    public function setAvaliableTimes($times){
        assert(is_array($times));

        $this->avaliableTimes = $times;
    }
}