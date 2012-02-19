<?php

/**
 * Jade.class.php – Handle Jade Template parsing
 * This file is part of php-kickstart (c) 2012 Sebastian Müller <c@semu.mp>
 *
 * @package    php-kickstart
 * @author     Sebastian Müller <c@semu.mp>
 * @license    MIT License – http://www.opensource.org/licenses/mit-license.php 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
  
require_once ABSPATH . '/vendor/jade/vendor/symfony/src/Symfony/Framework/UniversalClassLoader.php';

use Symfony\Framework\UniversalClassLoader;
$l = new UniversalClassLoader();
$l->registerNamespaces(array('Everzet' => ABSPATH . '/vendor/jade/src'));
$l->register();

use Everzet\Jade\Jade;
use Everzet\Jade\Parser;
use Everzet\Jade\Lexer\Lexer;
use Everzet\Jade\Dumper\PHPDumper;
use Everzet\Jade\Visitor\AutotagsVisitor;
use Everzet\Jade\Filter\JavaScriptFilter;
use Everzet\Jade\Filter\CDATAFilter;
use Everzet\Jade\Filter\PHPFilter;
use Everzet\Jade\Filter\CSSFilter;

/**
 * Custom Jade Wrapper
 **/
class JadeTemplate {
  var $jade, $dumper, $parser, $loader, $values = array(), $path = '';

  /**
   * Constructor
   * @param string $path where to find views
   **/
  public function __construct() {
    $this->path = ABSPATH . 'views/';
    
    $this->dumper = new PHPDumper();
    $this->dumper->registerVisitor('tag', new AutotagsVisitor());
    $this->dumper->registerFilter('javascript', new JavaScriptFilter());
    $this->dumper->registerFilter('cdata', new CDATAFilter());
    $this->dumper->registerFilter('php', new PHPFilter());
    $this->dumper->registerFilter('style', new CSSFilter());
    
    $this->parser = new Parser(new Lexer());
    $this->jade   = new Jade($this->parser, $this->dumper);    
    
    $this->clean();
  }
  
  /**
   * Custom to String handler
   * @return string
   */
  public function __toString() {
    return '[JadeTemplate Object]';
  }  

  /**
   * Clean assigned variables
   **/
  public function clean() {
    $this->values = array();
  }

  /**
   * Assign value to key
   * @param string $key
   * @param mixed $value
   **/
  public function assign($key, $value = null) {
    if (!is_array($key)) {
      $this->values[$key] = $value; }
    else {
      foreach ($key as $k => $v) {
        $this->assign($k, $v); }
    }
  }

  /**
   * Render template
   * @param string $view file
   **/
  public function render($view) {
    foreach ($this->values as $k => $v) {
      $$k = $v; } // Assign local vars
  
    if (substr($view, 0, 1) != '/') {
      $view = $this->path . $view; }
    if (!stristr($view, '.jade')) {
      $view = $view . '.jade'; }

    try {
      $tpl = $this->jade->render($view);
    } catch (Exception $e) {
      header('content-type: text/plain; charset=utf-8');
      die($e->highlightContext($this->jade->source));
    }

    eval ('?>' . $tpl);
  }
}