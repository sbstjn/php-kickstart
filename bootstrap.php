<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
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
$Router->all('*')->bind('Error', 'notFound');

/**
 * Parse current Request
 */
new Server($Router, new JadeTemplate(), new Logger());