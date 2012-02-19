<?php

/**
 * inc.functions.php – Define custom functions for general handling
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
 * Debug data
 * @param mixed $var data to be inspected
 */
function d($var) {
  header("Content-Type: text/plain");

  $trace = debug_backtrace();
  $last = $trace[0];

  $line = str_replace(ABSPATH, '', $last['file']) . ':' . $last['line'];
  echo "\n\n";
  echo ' ++' . str_pad('+', strlen($line), '+', STR_PAD_LEFT) . "+\n";
  echo ' + ' . $line . "\n\n";
  
  $data = print_r($var, true);
  $data = explode("\n", $data);
  
  foreach ($data as $line) {
    echo '   ' . $line . "\n"; }

  echo "\n\n";
}

/**
 * Display default Exception
 * @param Exception $e Exception
 */
function displayException(&$e) {
  header("Content-Type:text/plain");
    
  echo $e->getMessage() . "\nin ";
  echo str_replace(ABSPATH, '', $e->getFile()) . ':' . $e->getLine() . "\n\n";    
  $trace = ($e->getTrace());
  $counter = count($trace)-1;
    
  foreach ($trace as $step) {
    $step['file'] = str_replace(ABSPATH, '', $step['file']);
    if ($step['file'] == 'public/index.php') {
      continue; }
    echo str_pad($counter, 3, ' ', STR_PAD_LEFT) . ': ' . $step['file'].':'.$step['line'] . ' ';
    
    if (isset($step['class']) && isset($step['function'])) {
      echo $step['class'].$step['type'].$step['function'].'('.implode(', ', $step['args']).') ';
    } else if (isset($step['function'])) {
      echo $step['function'].'('.implode(', ', $step['args']).') ';
    } else {
      print_r($step);
    }
      
    $counter--;
    echo "\n";
  }  
    
  die();  
}


if (!function_exists('apache_request_headers')) { 
  /**
   * Get HTTP request headers
   * @return array
   */
  function apache_request_headers() { 
    foreach ($_SERVER as $key=>$value) { 
      if (substr($key,0,5)=="HTTP_") { 
        $key        = str_replace(" " , "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5))))); 
        $out[$key]  = $value; 
      } 
    } 
    return $out; 
  } 
}