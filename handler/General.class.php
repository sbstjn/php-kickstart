<?php

class General {

  public function home(&$req, &$res) {
    $res->render('home');    
  }
  
  public function check(&$req, &$res) {
    $res->assign('check', $req->param('optional'));
    $res->render('check');    
  }  
  
  public function download(&$req, &$res) {
    $res->assign('file', $req->param('file'));
    $res->assign('type', $req->param('type'));
  
    $res->render('download');
  }  

}