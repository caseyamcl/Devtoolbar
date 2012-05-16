<?php

/**
 * Dev Toolbar - A nifty universal and extensible development toolbar for PHP apps
 *
 * @package Devtoolbar
 * @author  Casey McLaughlin
 * @link    http://github.com/caseyamcl/Devtoolbar
 * @license MIT License
 */


namespace Devtoolbar\Tools;

/**
 * HTTP request information tool
 */
class Request extends Tool {

  /**
   * @var string
   */
  protected static $description = 'HTTP Request Information';

  // --------------------------------------------------------------

  public function __construct() {

    $this->indicator = 'HTTP';
    $this->caption   = 'Request Info';
    $this->details   = $this->getDetails();

  }

  // --------------------------------------------------------------

  private function getDetails() {
    $html = "<h6>HTTP \$_SERVER Array</h6>";
    $html .= $this->tableize($_SERVER);
    return $html;
  }
}

/* EOF: Request.php */