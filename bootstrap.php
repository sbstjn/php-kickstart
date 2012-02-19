<?php

/**
 * bootstrap.php – Initialize php-kickstart
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
 * Check environment and load configuration 
 */
if (!defined('ABSPATH')) {
  die('missing environment'); }
require_once ABSPATH . 'inc.config.php';

/**
 * Define Routing Handlers
 */
$Router = new Router(new Request(), new Response());

$Router->get('/')->bind('General', 'home');
$Router->get('/check/:optional?')->bind('General', 'check');
$Router->get('/download/:file/:type')->bind('General', 'download');

$Router->get('/downloadFile/:name?')->bind('General', 'downloadFile');
$Router->get('/downloadData')->bind('General', 'downloadData');

$Router->get('/api/:type')->bind('General', 'api');

$Router->all('*')->bind('Error', 'notFound');

/**
 * Parse current Request
 */
new Server($Router, new JadeTemplate(), new Logger());