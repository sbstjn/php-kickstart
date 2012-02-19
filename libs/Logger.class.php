<?php

/**
 * Logger.class.php – Default Logger
 * This file is part of php-kickstart (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * @package    php-kickstart
 * @author     Sebastian Müller <c@semu.mp>
 * @license    MIT License – http://www.opensource.org/licenses/mit-license.php 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Logger {

  public function action(&$req, &$res, $next) {
    // d($req);
    
    $next();
  }
  
  /**
   * Custom to String handler
   * @return string
   */
  public function __toString() {
    return '[Logger Object]';
  }

}