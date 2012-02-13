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
  
  public function downloadFile(&$req, &$res) {
    $res->downloadFile(ABSPATH . 'handler/General.class.php', $req->param('name'));
  }
  
  public function downloadData(&$req, &$res) {
    $res->downloadData('Lorem Ipsum', 'file.extension');
  }  
  
  public function api(&$req, &$res) {
    $res->assign('Lorem', 'Ipsum');
    $res->assign('Values', array(1,2,3,4,5,6));
    
    switch ($req->param('type')) {
      case 'xml':
        $res->renderXML();
        break;
      case 'json':
        $res->renderJSON();
        break;
    }
  }

}