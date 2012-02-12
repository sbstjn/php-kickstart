<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Start Output Buffer
 */
ob_start();

/**
 * Set path to your php-kickstart folder 
 */
define ('ABSPATH', str_replace('/public', '', __DIR__) . '/');

/**
 * Start-Up
 */
require_once ABSPATH . 'bootstrap.php';