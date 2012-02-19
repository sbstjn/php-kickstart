<?php

/**
 * General.class.php – Example handler for some actions
 * This file is part of php-kickstart (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * @package    php-kickstart
 * @author     Sebastian Müller <c@semu.mp>
 * @license    MIT License – http://www.opensource.org/licenses/mit-license.php 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
  
  public function throwExceptionUncaught(&$req, &$res) {
    throw new Exception('Uncaught Exception');
  }
  
  public function throwExceptionPassthru(&$req, &$res) {
    try {
      throw new Exception('Handled and thrown up');
    } catch (Exception $e) {
      throw $e;
    }
  }
  
  public function throwExceptionHandle(&$req, &$res) {
    try {
      throw new Exception('Handled and caught');
    } catch (Exception $e) {
      displayException($e);
    }  
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