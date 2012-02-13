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
   * Assigned template variables
   * @var array
   */
  var $data = array();

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
    $this->data[$name] = $value;
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
  
  /**
   * Send remote file to browser as download
   * @param string $file absolute file path
   * @param string $name custom filename
   */
  public function downloadFile($file, $name = null) {
    return $this->downloadData(file_get_contents($file), ($name != null ? $name : basename($file)));
  }

  /**
   * Send data to browser as download
   * @param string $data data to send as file download
   * @param string $name filename
   */  
  public function downloadData($data, $name) {
    header("Content-Description: File Transfer");
    header('Content-type: text/plain; name=' . $name);
    header('Content-Disposition: attachment; filename="' . $name .'"');
    header("Content-Length: ".strlen($data));
    header('Content-transfer-encoding: 8bit');
    header('Expires: 0');
    header('Cache-Control: private');
    header('Pragma: cache'); 
    
    echo $data;
  }
  
  /**
   * Export assigned values as JSON
   */  
  public function renderJSON() {
    header('Content-type: text/plain;');
    
    echo json_encode($this->data);
  }
  
  /**
   * Export assigned values as XML
   */    
  public function renderXML() {
    header('Content-type: text/plain;');
    
    echo XML::array2XML($this->data, 'data');
  }

}