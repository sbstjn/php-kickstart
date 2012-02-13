<?php

class XML {

  var $xml;
  var $indent;
  var $stack = array();
  var $currentSpace;  
  
  public function __construct($indent = 2, $enc = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n") {
    $this->indent           = $indent;
    $this->xml              = '';
    $this->currentSpace     = '';
    $this->currentIndention = 0;
    
    if ($enc != false) {
      $this->xml = $enc; }
  }

  private function indent() {
    $this->currentIndention += $this->indent;
  }  
  
  private function removeIndention() {
    $this->currentIndention -= $this->indent;
  }

  function spaces() {
    return str_pad('', $this->currentIndention, ' ', STR_PAD_LEFT);
  }
  
	function encode($str) {
		return str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $str);
	}  
	
	function add($str) {
	  $this->xml .= $str;
	}
	
  function push($el, $attr = array()) {
    array_push($this->stack, $el);
    $this->add($this->spaces());
    $this->add('<' . $el);

    foreach ($attr as $k => $v) {
      $this->add(' ' . $k . '="' . htmlentities($v) . '"'); }
    
    $this->add(">\n");
    $this->indent();
  }
  
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
  
  function pop() {
    $el = array_pop($this->stack);
    $this->removeIndention();

    $this->add($this->spaces());
    $this->add('</' . $el . '>' . "\n");
  }
  
  function getXML() {
    return $this->xml;
  }
  
  static function array2XML($array, $root = 'response') {
    $xml = new XML();
    $xml->push($root);
    $xml->element('Soon','Available');
    $xml->pop();
    
    echo $xml->getXML();
  }
  
}