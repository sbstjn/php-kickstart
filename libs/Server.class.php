<?php

/**
 * Server.class.php – Server handler for multiple Routers in future
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
 * Server Handler
 */
class Server {
  
  var $router;
  
  /**
   * Handle Request
   */
  public function __construct(&$Router, &$Template, &$Logger) {
    $this->router = $Router;
    $this->router->setTemplate($Template);
    $this->router->setLogger($Logger);
    
    $this->router->handle();
  }
  
  /**
   * Custom to String handler
   * @return string
   */
  public function __toString() {
    return '[Server Object]';
  }  
  
  /**
   * Handle Request
   * @param Router $Router
   */
  static function parse(Router &$Router) {
    $Router->handle();
  }
  
}