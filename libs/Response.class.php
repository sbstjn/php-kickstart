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
class Response {

  /**
   * Template Engine
   * @var object
   */
  private $tpl;
  
  /**
   * HTTP Response Code
   * @var integer
   */
  var $status = 200;

  /**
   * Initialize Response 
   */
  public function __construct() {

  }
  
  /**
   * Set Template Handler 
   * @param object $obj
   */
  public function setTemplate(&$obj) {
    $this->tpl = &$obj;
  }
  
  /**
   * Set HTTP Status Code for Response
   * @param int $code HTTP Status Code
   */
  public function status($code) {
    $this->status = $code;
  }
  
  /**
   * Write HTTP Response Status
   */
  public function writeStatus() {
    global $HTTP_STATUS;
    
    header("HTTP/1.0 ".$this->status." ".$HTTP_STATUS[$this->status]);
  }
  
  /**
   * Assign value to Response key
   * @param string $name 
   * @param mixed $value
   */  
  public function assign($name, $value = null) {
    $this->tpl->assign($name, $value);
  }
  
  /**
   * Render template
   * @param string $name template name or path
   */
  public function render($name) {
    $this->writeStatus();
      
    $this->tpl->render($name);
  }

}