<?php
class Proxy {
	public function GET($string = null){
		return ($string!=null)? $this->_get($string):$this->_get_null();
	}

	public function POST($string = null){
		return ($string!=null)? $this->_post($string):$this->_post_null();
	}

	private function _get($string){
		if(empty($_GET[$string]) || isset($_GET[$string])){return false;}
		return $this->Clear($_GET[$string]);
	}

	private function _get_null(){
		return $_GET;
	}

	private function _post($string){
		if(empty($_POST[$string]) || isset($_POST[$string]) ){return false;}
		return $this->Clear($_POST[$string]);
	}

	private function _post_null(){
		return $_POST;
	}

	private function Clear($string) 
	{
		$string = trim($string);
		$string = stripslashes($string);
		$string = htmlspecialchars($string);
		return $string;
	}
}