<?php
/*
 * Author : Cleve Gomes
 */
abstract class API
{

   /**
    either GET, POST, PUT or DELETE
   */
   protected $method = '';


   /**
   * The Model requested in the URI.
   */
   protected $endpoint = '';



   /**
   * An optional additional descriptor about the endpoint
   */
   protected $verb = '';



/**
* Any additional URI components after the endpoint and verb
 */
     protected $args = Array();


     /**
     * Stores the input of the PUT request
     */
     protected $file = NULL;

     /**
     * Constructor: __construct
     */
     public function __construct($request) {


	 /*
	  *    CORS for cross-origin HTTP request
	  */
     header("Access-Control-Allow-Orgin: *");
     header("Access-Control-Allow-Methods: *");
     header("Content-Type: application/json");

	     
     $this->args = explode('/', rtrim($request, '/'));

	 //Fetching the first value from the request which is the endpoint
     $this->endpoint = array_shift($this->args);
     if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
     $this->verb = array_shift($this->args);
     }

     $this->method = $_SERVER['REQUEST_METHOD'];

	 // Fetching the delete and put method from the  HTTP_X_HTTP_METHOD
     if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
     if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
     $this->method = 'DELETE';
     } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
     $this->method = 'PUT';
     } else {
     throw new Exception("Unexpected Header");
     }
     }

     switch($this->method) {
     case 'DELETE':  // delete
     case 'POST':    // Create or Add
     $this->request = $this->cleanup($_POST);
     break;
     case 'GET': // read
     $this->request = $this->cleanup($_GET);
     break;
     case 'PUT': //replace update
     $this->request = $this->cleanup($_GET);
     $this->file = file_get_contents("php://input");
     break;
     default:
     $this->response('Invalid Method', 405);
     break;
     }
     }


	/**
	 * Processing the API by calling the  endpoint function .
	 * @return string  . Success or Error message
	 */
     public function processAPI() {
     	if (method_exists($this, $this->endpoint)) {
     		return $this->response(["success"=>$this->{$this->endpoint}($this->args)]);
     	}
     	return $this->response(["Error"=> "No Endpoint:".$this->endpoint], 404);
     }

	/*
	 *  Building the Response message
	 */
     private function response($data, $status = 200) {
     	header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
     	return json_encode($data);
     }

	/*
	 * Cleaning the data Post or get data
	 */
     private function cleanup($data) {
     	$clean_input = Array();
     	if (is_array($data)) {
     		foreach ($data as $k => $v) {
     			$clean_input[$k] = $this->cleanup($v);
     		}
     	} else {
     		$clean_input = trim(strip_tags($data));
     	}
     	return $clean_input;
     }

	/**
	 * HTTP status code to HTTP code description
	 * @param $code
	 * @return mixed
	 */
     private function _requestStatus($code) {
     	$status = array(
     		200 => 'OK',
     		404 => 'Not Found',
     		405 => 'Method Not Allowed',
     		500 => 'Internal Server Error',
     	);
     	return ($status[$code])?$status[$code]:$status[500];
     }

}