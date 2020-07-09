<?php
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

    public function __set($key, $value) {
		
    }

    public function new_time($a) {
        $ndate = date('d.m.Y', (int)$a);
        $ndate_time = date('H:i', (int)$a);
        $ndate_exp = explode('.', $ndate);
        $nmonth = array(
         1 => 'янв',
         2 => 'фев',
         3 => 'мар',
         4 => 'апр',
         5 => 'мая',
         6 => 'июн',
         7 => 'июл',
         8 => 'авг',
         9 => 'сен',
         10 => 'окт',
         11 => 'ноя',
         12 => 'дек'
        );
       
        foreach ($nmonth as $key => $value) {
         if($key == intval($ndate_exp[1])) $nmonth_name = $value;
        }
       
        if($ndate == date('d.m.Y')) return 'сегодня в '.$ndate_time;
        elseif($ndate == date('d.m.Y', strtotime('-1 day'))) return 'вчера в '.$ndate_time;
        else return $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2].' в '.$ndate_time;
    }
}