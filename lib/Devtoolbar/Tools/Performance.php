<?php

namespace Devtoolbar\Tools;

class Performance extends Tool {

  /**
   * @var string
   */
  protected static $description = 'Performance Metrics';

  // --------------------------------------------------------------

  public function __construct() {

    $this->indicator = '15mb / 0.3s';
    $this->caption   = 'Memory &amp; Time';
    $this->details   = $this->getDetails();

  }

  // --------------------------------------------------------------

  private function getDetails() {
    return "<p>Perf Details</p>";
  }
}

/* EOF: Performance.php */