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
  var $tpl;

  /**
   * Initialize Response 
   */
  public function __construct() {
    $this->tpl = new JadeHandler(ABSPATH . 'views/');
  }

  /**
   * Assign value to Response key
   * @param string $name 
   * @param mixed $value
   */  
  public function assign($name, $value = null) {
    $tpl->assign($name, $value);
  }
  
  /**
   * Render template
   * @param string $name template name or path
   */
  public function render($name) {
    $tpl->render($name);
  }

}