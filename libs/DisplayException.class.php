<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
/**
 * Display Exception 
 */
class DisplayException {
  
  /**
   * Display Exception with StackTrace
   * @param Exception $e
   */
  public function __construct(&$e) {
    header("Content-Type:text/plain");
    
    echo $e->getMessage() . "\n\n";
    $trace = array_reverse($e->getTrace());
    
    foreach ($trace as $step) {
      $step['file'] = str_replace(ABSPATH, '', $step['file']);
    
      echo $step['file'].':'.$step['line'] . ' ';
    
      if (isset($step['class']) && isset($step['function'])) {
        echo $step['class'].$step['type'].$step['function'].'('.implode(', ', $step['args']).') ';
      } else if (isset($step['function'])) {
        echo $step['function'].'('.implode(', ', $step['args']).') ';
      } else {
        print_r($step);
      }
      
      echo "\n";
    }  
    
    die();  
  }
  
}