<?php
class Controller{
	public $_error = array();
	public $adress, $proxy, $post, $get, $model, $document, $render;

	public function __construct($registry){
		extract($registry);

		$this->adress = $_SERVER['REQUEST_URI'];

		$this->proxy 	= $proxy;
		$this->document = $document;

		$this->post 	= $post;
		$this->get		= $get;
		
		$this->render = new Render;
		$this->model = new Model($registry);
	}

	function header(){

		$data['class'] = "";
		$data['base'] = ($_SERVER['HTTP_HOST'] != "localhost")? ($_SERVER['HTTPS'] == true)? HTTPS_SERVER:HTTP_SERVER:"http://localhost/";

		$data['title'] = $this->document->getTitle();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();

		return $this->render->load("common/header", $data);
    }
    
    function left(){

        $data['user'] = $this->model->account->get($_SESSION['uid']);
		$data['class'] = $_GET['route'];

		return $this->render->load("common/left", $data);
	}
	
	function footer(){
		$data['scripts'] = $this->document->getScripts('footer');
		return $this->render->load("common/footer", $data);
	}

    function password(){
		$data['scripts'] = $this->document->getScripts('footer');
		return $this->render->load("common/password", $data);
	}

	function SetError($key, $value){
		$this->_error[$key] = $value;
		return (in_array($key, $this->_error) == true)? $this->_error[$key]:null;
	}

	function GetError($key){
		return (array_key_exists($key, $this->_error) == true)? $this->_error[$key]:null;
    }
    
    function Clear($obj){
        if(strlen($obj) < 3 or strlen($obj) > 30)
        {
            return 1;
        }

        return $obj;
    }

    function htmlEncode($string)
    {
        return htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
    }

    function getRequestValue($paramName, $trimInput = true)
    {
        if(isset($_REQUEST[$paramName]))
        {
            $ret =  $_REQUEST[$paramName];
            if($ret != NULL)
            {
                if($trimInput)
                {
                    $ret = trim($ret);
                }
            }
            $ret = iconv('windows-1251', 'UTF-8', $ret);
            return $ret;
        }
        else
        {
            return NULL;
        }
    }

    function getRequestStringValue($name, $fieldName, $trimInput = true, $printErrorMessage = true)
    {
        $value = $this->getRequestValue($name, $trimInput);
        $ret = $this->checkStringValue($value, $fieldName, $printErrorMessage);
        if($ret)
        {
            return $value;
        }
        else
        {
            return null;
        }
    }

    function checkStringValue($value, $fieldName, $printErrorMessage = true)
    {
        if($value == "" || $value == null)
        {
            if($printErrorMessage)
            {
                echo "Поле '".$fieldName."' не заполнено!";
            }
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
    * Закачивает содержимое файла по URL в строку
    *
    * @param string $url URL файла
    * @param int $maxlength Макс длина файла
    * @param int $timeout Таймаут ожидания запроса. Должен быть > 0 или -1, чтобы действовать.
    * Если == -1, то используется значение 60
    * @param bool $disableWarnings Не выводить сообщения об ошибках
    * @return string Содержимое файла или FALSE в случае неудачи
    */
    function getContent($url, $maxlength = null, $timeout = -1, $disableWarnings = true)
    {
        $ret = null;
        if($timeout == -1)
        {
            $timeout = 60;
        }

        if($timeout > 0)
        {
            ini_set('default_socket_timeout', $timeout);
        }

        $errorLevel = null;
        if($disableWarnings)
        {
            $errorLevel = error_reporting(E_ERROR);
        }

        $context = null;
        if($maxlength == null)
        {
            $ret = file_get_contents($url, False, $context);
        }
        else
        {
            $ret = file_get_contents($url, False, $context, 0, $maxlength);
        }

        if($disableWarnings)
        {
            error_reporting($errorLevel);
        }

        if($ret !== FALSE)
        {
            if($ret != null)
            {
                $ret = trim($ret);
            }
        }
        
        return $ret;
    }

	function HTTPStatus($num) {
    $http = array(
        100 => 'HTTP/1.1 100 Continue',
        101 => 'HTTP/1.1 101 Switching Protocols',
        200 => 'HTTP/1.1 200 OK',
        201 => 'HTTP/1.1 201 Created',
        202 => 'HTTP/1.1 202 Accepted',
        203 => 'HTTP/1.1 203 Non-Authoritative Information',
        204 => 'HTTP/1.1 204 No Content',
        205 => 'HTTP/1.1 205 Reset Content',
        206 => 'HTTP/1.1 206 Partial Content',
        300 => 'HTTP/1.1 300 Multiple Choices',
        301 => 'HTTP/1.1 301 Moved Permanently',
        302 => 'HTTP/1.1 302 Found',
        303 => 'HTTP/1.1 303 See Other',
        304 => 'HTTP/1.1 304 Not Modified',
        305 => 'HTTP/1.1 305 Use Proxy',
        307 => 'HTTP/1.1 307 Temporary Redirect',
        400 => 'HTTP/1.1 400 Bad Request',
        401 => 'HTTP/1.1 401 Unauthorized',
        402 => 'HTTP/1.1 402 Payment Required',
        403 => 'HTTP/1.1 403 Forbidden',
        404 => 'HTTP/1.1 404 Not Found',
        405 => 'HTTP/1.1 405 Method Not Allowed',
        406 => 'HTTP/1.1 406 Not Acceptable',
        407 => 'HTTP/1.1 407 Proxy Authentication Required',
        408 => 'HTTP/1.1 408 Request Time-out',
        409 => 'HTTP/1.1 409 Conflict',
        410 => 'HTTP/1.1 410 Gone',
        411 => 'HTTP/1.1 411 Length Required',
        412 => 'HTTP/1.1 412 Precondition Failed',
        413 => 'HTTP/1.1 413 Request Entity Too Large',
        414 => 'HTTP/1.1 414 Request-URI Too Large',
        415 => 'HTTP/1.1 415 Unsupported Media Type',
        416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
        417 => 'HTTP/1.1 417 Expectation Failed',
        500 => 'HTTP/1.1 500 Internal Server Error',
        501 => 'HTTP/1.1 501 Not Implemented',
        502 => 'HTTP/1.1 502 Bad Gateway',
        503 => 'HTTP/1.1 503 Service Unavailable',
        504 => 'HTTP/1.1 504 Gateway Time-out',
        505 => 'HTTP/1.1 505 HTTP Version Not Supported',
    );
 
    header($http[$num]);
 
    return
        array(
            'code' => $num,
            'error' => $http[$num],
        );
	}

}

