<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
/**
 * Server Handler
 */
class Server {
  
  /**
   * Handle Request
   * @param Router $Router
   */
  static function parse(Router &$Router) {
    $Router->handle();
  }
  
}