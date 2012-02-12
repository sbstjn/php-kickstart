<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
/**
 * FileNotFound Exception
 */
class FileNotFound extends Exception {

  /**
   * Create new FileNotFile Exception with message and error number
   * @param string $msg Exception message
   * @param int $num Error numer
   */
  public function __construct($msg, $num = 0) {
    parent::__construct($msg, $num);
  }

  /**
   * Return on Exeption description
   * @return string
   */
  public function __toString() {
    return __CLASS__ . ": [" . $this->num . "]: " . $this->msg . "\n";
  }
  
}