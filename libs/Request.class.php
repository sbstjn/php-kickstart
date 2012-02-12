<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Request Object
 */
class Request {

  /**
   * Current URL Object
   * @var URL
   */
  var $url;
  
  /**
   * Current HTTP method
   * @var string
   */  
  var $method;
  
  /**
   * Current HTTP headers
   * @var array
   */  
  var $header;
  
  /**
   * Current browser cookies
   * @var array
   */  
  var $cookies;

  /**
   * Initialize Request object
   */
  public function __construct() {
    $this->id = $_ENV['UNIQUE_ID'];
    $this->method = $_ENV['REQUEST_METHOD'];
    
    $this->parseURL();
    $this->parseHeader();
    $this->parseCookies();   
  }
  
  /**
   * Parse current url to URL Object
   */
  private function parseURL() {
    $this->url = new URL();
  }
  
  /**
   * Parse HTTP headers
   */  
  private function parseHeader() {
    $this->header = apache_request_headers();
  }
  
  
  /**
   * Parse web browser cookies
   */  
  private function parseCookies() {
    if (!isset($this->header['Cookie'])) {
      $this->cookies = array(); 
      $this->header['Cookie'] = ''; 
    }
    
    $this->cookies = $_COOKIE;
  }
  
}