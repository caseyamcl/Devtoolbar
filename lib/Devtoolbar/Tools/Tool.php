<?php

namespace Tools;

abstract class Tool {

  /**
   * @var string
   */
  protected static $description;

  /**
   * @var string
   */
  protected $indicator;

  /**
   * @var string
   */
  protected $caption;

  /**
   * @var string
   */
  protected $details;

  // --------------------------------------------------------------
  
  public function __get($val) {

    if (isset(self::$$val) {
      return self::$$val;
    }
    elseif (isset($this->$val)) {
      return $this->$val;
    }
  }

}

/* EOF: Session.php */