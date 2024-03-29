<?php

/**
 * Router.class.php – Route handling and binding
 * This file is part of php-kickstart (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * @package    php-kickstart
 * @author     Sebastian Müller <c@semu.mp>
 * @license    MIT License – http://www.opensource.org/licenses/mit-license.php 
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
   * Logger Object
   * @var Logger
   */
  var $logger;
  
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

  /**
   * Custom to String handler
   * @return string
   */
  public function __toString() {
    return '[Router Object]';
  }
  
  
  /**
   * Set Logger object
   * @param Logger $obj
   */
  public function setLogger(&$obj) {
    $this->logger = &$obj;
  }
  
  /**
   * Set Templater Handler
   * @param object $obj
   */
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
        
      $regex = preg_replace('/\/:([a-zA-Z0-9]*)\//', '/([^/]*)/', $this->tmp);
      $regex = preg_replace('/\/:[a-zA-Z0-9]*$/', '/([^/]*)', $regex);
      $regex = preg_replace('/\/:([^\?]*)\?/', '/([^/]*)', $regex);
      $regex = "/" . str_replace('/', '\/', $regex) . "$/";
        
      $handler = array(
        'url'     => $this->tmp,
        'regex'   => $regex,
        'method'  => $this->nextMethod,
        'handler' => array($obj, $func));
      array_push($this->routes, $handler);
    } catch (Exception $e) {
      displayException($e);
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
    
    $result = array();
    preg_match_all($route['regex'], $this->req->url->path, $result, PREG_PATTERN_ORDER);
    
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
    foreach ($routes as &$route) {
      $this->step++;
      
      try {
        if ($this->urlMatchesRoute($route)) {
          $this->req->url->parseParametersWithRoute($route);
        
          $this->handler[$route['handler'][0]]->$route['handler'][1]($this->req, $this->res, $this);
          break;
        } else {

        }     
      } catch (Exception $e) {
        displayException($e);
      }      
    }

  } 

}