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
 * Memory usage reporting tools
 */
class Memory extends Tool {

  /**
   * @var string
   */
  protected static $description = 'Memory Usage Metrics';

  // --------------------------------------------------------------

  public function __construct() {

    $this->indicator = number_format((memory_get_peak_usage() / 1048576), 2) . 'mb';
    $this->caption   = 'Memory Usage';
    $this->details   = $this->getDetails();

  }

  // --------------------------------------------------------------

  private function getDetails() {
    $html = "<h6>Memory Usage Details</h6>";

    $stats = array(
      'Memory Usage (bytes)' => memory_get_peak_usage(),
      'Memory Usage (mb)'    => number_format((memory_get_peak_usage() / 1048576), 2) . 'mb'
    );

    $html .= $this->tableize($stats);
    return $html;
  }
}

/* EOF: Performance.php */