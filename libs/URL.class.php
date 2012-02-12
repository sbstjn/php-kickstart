<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * URL Object
 */
class URL {

  /**#@+
   * @var string
   */
  var $scheme;
  var $host;
  var $path;
  var $query;
  /**
   * Request parameters
   * @var array
   */
  var $params;

  /**
   * Initialize URL by server Environment
   */
  public function __construct() {
    $raw = (isset($_ENV['HTTPS']) && $_ENV['HTTPS'] == 'on' ? 'https://' : 'http://') . $_ENV['SERVER_NAME'] . $_ENV['REQUEST_URI'];
    $url = parse_url($raw);
    
    $this->url    = $raw;
    $this->scheme = $url['scheme'];
    $this->host   = $url['host'];
    $this->path   = $url['path'];
    $this->query  = $url['query'];
    
    $this->parseParams();
  }
  
  /**
   * Get parameter from URL
   * @param string $key parameter name
   * @param mixed $default default return if key not found
   * @return mixed
   */
  public function param($key, $default = null) {
    if (!isset($this->params[$key])) {
      return $default; }
    return $this->params[$key];
  }
  
  /**
   * Parse request parameters
   * @access @private
   */
  private function parseParams() {
    $params = array();
    $params = $this->parseQuery($this->query);
    
    $this->params = $params;
  }
  
  /**
   * Parse HTTP query string
   * @param string $query HTTP query string
   * @return array 
   */
  private function parseQuery($query) {
    $return = '';
    parse_str($query, $return);
    
    return $return;
  }
  
  /**
   * Parse Request with regex for route
   * @param string $regex
   */
  public function parseParametersWithRoute(&$route) {
    if (!stristr($route['url'], ':')) {
      return; }
  
    $data = '';
    preg_match_all($route['regex'], $this->path, $data, PREG_SET_ORDER);
    array_shift($data[0]);
    $values = $data[0];
  
    $data = '';
    preg_match_all($route['regex'], $route['url'], $data, PREG_SET_ORDER);
    array_shift($data[0]);
    $params = array();    
    foreach ($data[0] as $k => $v) {
      $params[str_replace(array(':', '?'), '', $v)] = $values[$k];
    }

    $this->params = array_merge($this->parseQuery($this->query), $params);
  }  

}