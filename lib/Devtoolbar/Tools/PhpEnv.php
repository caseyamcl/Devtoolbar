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
class PhpEnv extends Tool {

  /**
   * @var string
   */
  protected static $description = 'PHP Environmental Variables';

  // --------------------------------------------------------------

  public function __construct() {

    $this->indicator = 'PHP';
    $this->caption   = 'Enviornmental Info';
    $this->details   = $this->getDetails();

  }

  // --------------------------------------------------------------

  private function getDetails() {
    $html = "<h6>PHP Extensions</h6>";
    $html .= $this->tableize(get_loaded_extensions());
    return $html;
  }
}

/* EOF: PhpEnv.php */