<?php

class Logger {

  public function action(&$req, &$res, $next) {
    // d($req);
    
    $next();
  }

}