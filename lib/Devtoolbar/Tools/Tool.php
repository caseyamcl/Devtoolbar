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
 * Tool baseclass
 */
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
  
  /**
   * Magic Method allows getting some properties
   *
   * @param string $val
   * @return mixed 
   */
  public function __get($val) {

    $allowed = array('indicator', 'caption', 'details');

    if (isset($this->$val) && in_array($val, $allowed)) {
      return $this->$val;
    }
  }

  // --------------------------------------------------------------

  /**
   * Get the description of the tool
   *
   * @return string
   */
  public function getDescription() {
    return (isset(self::$description)) ? self::$description : $this->caption . ' tool';
  }

  // --------------------------------------------------------------

  /**
   * Convert a bunch of values into a HTML table
   *
   * @param array $values   If incremental, will only show one column, if associative, will show two columns
   * @param array $headers  Optional headers
   * @return string Table HTML
   */
  protected function tableize($values, $headers = array()) {

    //Do headers
    $header_html = '';
    if ( ! empty($headers)) {
      foreach($headers as $header) {
        $header_html .= "<th>" . $header . "</th>";
      }
    }
    $header_html = "<thead><tr>" . $header_html . "</tr></thead>";

    //Determine if array is incremental or associative
    $assoc = (array_keys($values) !== range(0, count($values) - 1));

    //Do body
    $body_html = '';
    foreach($values as $k => $v) {
      if ($assoc) {
        $body_html .= "<tr><th scope='row'>$k</th><td>$v</td></tr>";
      }
      else {
        $body_html .= "<tr><td>$v</td></tr>";
      }
    }
    $body_html = "<tbody>" . $body_html . "</tbody>";

    if ( ! empty($headers)) {
      $body_html = $header_html . $body_html;
    }

    return "<table class='devbar_tooltable'>" . $body_html . "</table>";

  }

}

/* EOF: Session.php */