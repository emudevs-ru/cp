<?php
/*
    Autor: mrSlink
    Update date: 9.07.2020
    Description:
    Standard model. Based on, but changed model from OpenCart 3

    Need add DB functions
*/
class Model {
    public $registry, $adress, $proxy, $post, $get, $document, $render;

	public function __construct($registry){
        $this->registry = $registry;
        extract($registry);

		$this->adress = $_SERVER['REQUEST_URI'];

		$this->proxy 	= $proxy;
        $this->document = $document;

		$this->post 	= $post;
		$this->get		= $get;
    }
    
    public function __get($key){
        if(file_exists(DIR_MODEL.$key.'.php')){
            require_once(DIR_MODEL.$key.'.php');

            $model = "Model".$key;
            return new $model($this->registry);
        }
        return null;
    }
}