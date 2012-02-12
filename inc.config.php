<?php

/*
 * This file is part of the php-kickstart.
 * (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (__DIR__ == '__DIR__') {
  die('you need php >=5.3 get this working…'); }

require_once ABSPATH . 'inc.functions.php';

require_once ABSPATH . 'libs/JadeHandler.class.php';
require_once ABSPATH . 'libs/URL.class.php';
require_once ABSPATH . 'libs/Router.class.php';
require_once ABSPATH . 'libs/Request.class.php';
require_once ABSPATH . 'libs/Response.class.php';
require_once ABSPATH . 'libs/DisplayException.class.php';
require_once ABSPATH . 'libs/Server.class.php';

require_once ABSPATH . 'libs/Exceptions/FileNotFound.class.php';