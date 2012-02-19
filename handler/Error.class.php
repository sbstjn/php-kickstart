<?php

/**
 * Error.class.php – Example handler for default 404 errors
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
  * Error handler
  */
class Error {

  /**
   * Not found
   * @param Request $req Request object
   * @param Response $res Response object
   */
  function notFound(&$req, &$res) {
    $res->status(404);
    $res->assign('error', array('code' => 404));
    
    $res->render('error');
  }

}