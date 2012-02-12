<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
/**
 * Routing Handler
 */
class Router {

  /**
   * Request Object
   * @var Request
   */
  var $req;
  
  /**
   * Response Object
   * @var Response
   */  
  var $res;
  
  /**
   * Array of registered handlers
   * @var array
   */  
  var $handler;
  
  /**
   * Array of registered routes
   * @var array
   */  
  var $routes;
  
  /**
   * Counter for routing loop
   * @access private
   * @var int
   */  
  var $step = 0;
  
  /**
   * Temp. storage for registering routes
   * @access @private
   * @var mixed
   */  
  var $tmp;

  /**
   * Initialize Router
   * @param Request $req
   * @param Response $res
   */
  public function __construct(&$req, $res) {
    $this->req = $req;
    $this->res = $res;
    
    $this->handler = array();
    $this->routes = array();
  }
  
  public function setLogger(&$obj) {
  
  }
  
  public function setTemplate(&$obj) {
    $this->res->setTemplate($obj);
  }

  /**
   * Prepare for binding a new POST url
   * @param string $url 
   * @return Router
   */
  public function post($url) {
    $this->tmp = $url;
    $this->nextMethod = 'post';
    return $this;
  }

  /**
   * Prepare for binding a new GET url
   * @param string $url 
   * @return Router
   */  
  public function get($url) {
    $this->tmp = $url;
    $this->nextMethod = 'get';
    return $this;
  }
  
  /**
   * Prepare for binding a new url (all HTTP methods)
   * @param string $url 
   * @return Router
   */  
  public function all($url) {
    $this->tmp = $url;
    $this->nextMethod = 'all';
    return $this;
  }  
  
  /**
   * Bind callback to prepared url and HTTP method
   * @param string $obj Handler name
   * @param string $func Handler method
   */  
  public function bind($obj, $func) {
    try {    
      if (!isset($this->handler[$obj])) {
        $file = ABSPATH . 'handler/' . $obj . '.class.php';
        if (!file_exists($file)) {
          throw new Exception('Handler not found: handler/' . $obj . '.class.php'); }    
        require_once $file;
        
        $this->handler[$obj] = new $obj;
      }
      
      if (!method_exists($this->handler[$obj], $func)) {
        throw new Exception('Unkown handler "' . $func . '" for object "' . $obj . '"'); }      
        
      $handler = array(
        'url'     => $this->tmp,
        'method'  => $this->nextMethod,
        'handler' => array($obj, $func));
      array_push($this->routes, $handler);
    } catch (Exception $e) {
      new DisplayException($e);
    }  
  }
  
  /**
   * Check if current URL matches given Route
   * @param array $route Route to check
   * @return bool
   */
  private function urlMatchesRoute(&$route) {
    if ($route['method'] != strtolower($this->req->method) && $route['method'] != 'all') {
        return false; }
    if ($route['url'] == '*' || $route['url'] == $this->req->url->path) {
      return true; }
    if ($route['url'] == '/' && $this->req->url->path != $route['url']) {
      return false; } /* Dirty hack for '/' */
    
    $regex = preg_replace('/\/:([a-zA-Z0-9]*)\//', '/([^/]*)/', $route['url']);
    $regex = preg_replace('/\/:[a-zA-Z0-9]*$/', '/([^/]*)', $regex);
    $regex = preg_replace('/\/:([^\?]*)\?/', '/([^/]*)', $regex);
    $regex = "/" . str_replace('/', '\/', $regex) . "$/";

    $result = array();
    preg_match_all($regex, $this->req->url->path, $result, PREG_PATTERN_ORDER);
    
    if (count($result[0]) > 0) {
      return true; }
    return false;
  }
 
  /**
   * Run next binding in chain
   */
  public function next() {
    $this->handle();
  }
 
  /**
   * Start handling current Request
   */
  public function handle() {
    global $Router;
    
    $routes = array_slice($this->routes, $this->step);
    foreach ($routes as $route) {
      $this->step++;
      
      if ($this->urlMatchesRoute($route)) {
        $this->handler[$route['handler'][0]]->$route['handler'][1]($this->req, $this->res, function() { global $Router; $Router->next(); });
        break;
      } else {

      }     
    }

  } 

}