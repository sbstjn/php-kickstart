<?php

/**
 * XML.class.php – XML Writer for default XML API export
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
  * XML Writer
  */
class XML {

  /**
   * Storage for generated XML content
   * @var string
   */
  var $xml;
  
  /**
   * Level of whitespaces per indent
   * @var integer
   */
  var $indent;
  
  /**
   * XML element stack
   * @var array
   */  
  var $stack = array();
  
  /**
   * Current indention
   * @var string
   */  
  var $currentSpace;  
  
  /**
   * Number of spaces needed to indent
   * @var int
   */    
  var $currentIndention;

  /**
   * Initialize XML writer object and set encoding
   * @param int $indent set number of spaces used for indention each level
   * @param string $enc set first line to set encoding information
   */
  public function __construct($indent = 2, $enc = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n") {
    $this->indent           = $indent;
    $this->xml              = '';
    $this->currentSpace     = '';
    $this->currentIndention = 0;
    
    if ($enc != false) {
      $this->xml = $enc; }
  }

  /**
   * Add indention level
   */
  private function indent() {
    $this->currentIndention += $this->indent;
  }  
  
  /**
   * Decrease indention level
   */  
  private function removeIndention() {
    $this->currentIndention -= $this->indent;
  }

  /**
   * Get needed whitespace for current line
   * @return string
   */
  function spaces() {
    return str_pad('', $this->currentIndention, ' ', STR_PAD_LEFT);
  }
  
  /**
   * Encode values for XML data
   * @param string $str data
   * @return string
   */  
	function encode($str) {
		return str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $str);
	}  
	
  /**
   * Add data to XML string
   * @param string $str string to be added
   */  
	function add($str) {
	  $this->xml .= $str;
	}
	
  /**
   * Push element to XML tree
   * @param string $el element name
   * @param array $attr attributes
   */  
  function open($el, $attr = array()) {
    array_push($this->stack, $el);
    $this->add($this->spaces());
    $this->add('<' . $el);

    foreach ($attr as $k => $v) {
      $this->add(' ' . $k . '="' . htmlspecialchars($v, ENT_QUOTES, 'UTF-8') . '"'); }
    
    $this->add(">\n");
    $this->indent();
  }
  
  /**
   * Create element with data and optional attributes
   * @param string $el element name
   * @param string $data element's value
   * @param array $attr element's attributes with key => value
   */  
  function element($el, $data, $attr = array()) {
    $this->add($this->spaces());
    $this->add('<' . $el);
        
    foreach ($attr as $k => $v) {
      $this->add(' ' . $k . '="' . htmlspecialchars($v, ENT_QUOTES, 'UTF-8') . '"'); }

		if ($data) {
      $this->add('>' . $this->encode($data) . '</' . $el . '>' . "\n"); }
		else {
      $this->add(' />' . "\n"); }
  }
  
  /**
   * End indention
   */  
  function close() {
    $el = array_pop($this->stack);
    $this->removeIndention();

    $this->add($this->spaces());
    $this->add('</' . $el . '>' . "\n");
  }
  
  /**
   * Get generated XML content
   * @return string
   */  
  function getXML() {
    return $this->xml;
  }
  
  /**
   * Get needed whitespace for current line
   * @return string
   */  
  static function array2XML($array, $root = 'response') {
    $xml = new XML();
    $xml->open($root);
    $xml->element('Soon', 'Available');
    $xml->close();
    
    echo $xml->getXML();
  }
  
}