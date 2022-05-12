<?php

namespace App\core;

class Request{
    public static $instance = null;
    private function __construct()
    {
        
    } 
    public function getPath(){
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path , '?');
        if ($position === false){
            return $path;
        }
        return substr($path , 0 , $position);
    }

    public function getMethod(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public static function  getInstance(){
        if(self::$instance==null)
            self::$instance=new self;
        return self::$instance;
    }

    public function getInput(){
        $result = [];
        foreach($_GET as $key=>$value)
            $result[$key] = filter_input(INPUT_GET,$key);
        return $result;
    }

    public function postInput(){
        $result = [];
        foreach($_POST as $key=>$value)
            $result[$key] = filter_input(INPUT_POST,$key);
        return $result;
    }


    public function getBody(){
        if($this->getMethod()=='get')
            return $this->getInput();
        return $this->postInput();
    }

}