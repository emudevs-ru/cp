<?php
final class Router{
    private $registry;
    private $proxy;
    private $document;
    
    public function __construct($registry){
        $this->registry = $registry;
        $this->proxy = $registry['proxy'];
        $this->document = new Document;
    }

    
    public function route($adress){
        return $this->routing($this->_route($adress));
    }

    private function _route($adress){
        if(strpos($adress, "/")){
            return explode("/", $adress);
        } else {
            return $adress;
        }
        
    }

    private function controller($array){

        list($controller, $function) = $array;

        if(file_exists(DIR_CONTROLLER.$controller.'.php')){

            require_once(DIR_CONTROLLER.$controller.'.php');
            $controller = "Controller".$controller;

            if(method_exists($controller,$function)){

                $a = new $controller($this->registry);
                $a->$function();

            } else {

                return false;

            }
            
        } else {
            return false;
        }
        
        return true;
    }

    private function routing($adress){
        if(is_array($adress)){
            $this->controller($adress);
        } else {
            $this->controller([$adress, "index"]);
        }
    }
}