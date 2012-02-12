<?php

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