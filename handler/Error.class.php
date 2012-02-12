<?php

class Error {

  function notFound(&$req, &$res) {
    $res->status(404);
    $res->assign('error', array('code' => 404));
    
    $res->render('error');
  }

}