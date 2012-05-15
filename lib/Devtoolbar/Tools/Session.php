<?php

namespace Tools;

class Session extends Tool {

  /**
   * @var string
   */
  protected static $description = 'Session Values and Statistics';



  // --------------------------------------------------------------

  public function __construct() {

    $this->indicator = isset($_SESSION) ? count($_SESSION) : 'Off';
    $this->caption = 'Session Values';
    $this->details = $this->getDetails();

  }

  // --------------------------------------------------------------

  private function getDetails() {
    return "<p>Session Details</p>";
  }
}

/* EOF: Session.php */