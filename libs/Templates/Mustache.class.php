<?php

/**
 * Mustache.class.php – Handle Mustache Template rendering
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
 * Custom Jade Wrapper
 **/
class MustacheTemplate {
  var $mustache, $values = array(), $path = '';

  /**
   * Constructor
   * @param string $path where to find views
   **/
  public function __construct($path) {
    $this->path = $path;
    
    $this->clean();
  }

  /**
   * Custom to String handler
   * @return string
   */
  public function __toString() {
    return '[MustacheTemplate Object]';
  }  

  /**
   * Clean assigned variables
   **/
  public function clean() {
    $this->values = array();
  }

  /**
   * Assign value to key
   * @param string $key
   * @param mixed $value
   **/
  public function assign($key, $value = null) {
    if (!is_array($key)) {
      $this->values[$key] = $value; }
    else {
      foreach ($key as $k => $v) {
        $this->assign($k, $v); }
    }
  }

  /**
   * Render template
   * @param string $view file
   **/
  public function render($view) {
    foreach ($this->values as $k => $v) {
      $$k = $v; } // Assign local vars
  
    if (substr($view, 0, 1) != '/') {
      $view = $this->path . $view; }
    if (!stristr($view, '.mustache')) {
      $view = $view . '.mustache'; }

    d($view);
  }
}