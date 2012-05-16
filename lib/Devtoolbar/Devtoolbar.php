<?php

/**
 * Dev Toolbar - A nifty universal and extensible development toolbar for PHP apps
 *
 * @package Devtoolbar
 * @author  Casey McLaughlin
 * @link    http://github.com/caseyamcl/Devtoolbar
 * @license MIT License
 */

namespace Devtoolbar;

/**
 * Main Dev Toolbar class
 */
class Devtoolbar {

  const LISTITEM   = 1;
  const DETAILPANE = 2;

  /**
   * @var  The directory of this library
   */
  private $this_dir;

  /**
   * @var  An array of Tools\Tool objects (keys are tool basename)
   */
  private $tools = array();

  // --------------------------------------------------------------

  /**
   * Constructor
   *
   * Optionally disable some built-in tools by passing their basename (e.g. 'Memory' or
   * 'Session') in via the disableTools array
   *
   * @param $disableTools
   */
  public function __construct($disableTools = array()) {

    $this->dir = __DIR__ . DIRECTORY_SEPARATOR;
    $this->registerBuiltinTools($disableTools);
  }

  // --------------------------------------------------------------

  /**
   * Render Devtoolbar HTML
   *
   * @param boolean $withStyleAndJs  If TRUE, will return JS and CSS HTML includes
   * @return string  HTML output
   */
  public function render($withStyleAndJs = FALSE) {

    $html = ($withStyleAndJs) ? $this->renderStyleAndJs : '';

    $htmlList = "<li class='hide'>&laquo;</li>";
    $htmlDetails = '';

    if (count($this->tools) > 0) {

     foreach($this->tools as $toolname => $tool) {
        $htmlList .= $this->renderTool($toolname, $tool);
        $htmlDetails .= $this->renderTool($toolname, $tool, self::DETAILPANE);
      }

    }
    else {
      $htmlList .= $this->renderNoTools();
    }
    $htmlList .= "<li class='close'>X</li>";

    return "<div id='devtoolbar'><div id='detailpane'>" . $htmlDetails . "</div><ul class='tools'>" . $htmlList . "</ul></div>";
  }

  // --------------------------------------------------------------

  /**
   * Render Style and Javascript HTML includes
   *
   * Typically, you'll want to call this method to be included in your HTML
   * header output, but these HTML attributes will technically run in most
   * browsers if they are included in your <body>
   *
   * @return string  HTML Output
   */
  public function renderStyleAndJs() {

    $html = '';
    $html .= "<style type='text/css'>" .  file_get_contents($this->dir . 'style.css') . "\n</style>\n";
    $html .= "<script type'text/js'>" . file_get_contents($this->dir . 'scripts.js') . "\n</script>\n";

    return $html;
  }

  // --------------------------------------------------------------

  /**
   * HTML to return if no tools exist, or if all tools disabled
   *
   * @return string HTML Output
   */
  private function renderNoTools() {
    return "<li class='notool'><span class='msg'>No Tools Installed</span></li>";
  }

  // --------------------------------------------------------------

  /**
   * Render the HTML for a tool
   *
   * @param string $toolname  The toolname (basename of the class e.g. Session or Memory)
   * @param Tools\Tool $tool  The tool object
   * @param int $which        Which HTML to render, the listitem or the detail pane
   * @return string           HTML output
   */
  private function renderTool($toolname, $tool, $which = self::LISTITEM) {

    $html  = '';

    switch ($which) {

      case self::DETAILPANE:
        $html .= "<div class='tooldetails details {$toolname}'>" . $tool->details . "</div>";
      break;
      case self::LISTITEM:
        $html .= "<span class='indicator'>" . $tool->indicator . "</span>";
        $html .= "<span class='caption'>". $tool->caption . "</span>";
        $html = "<li class='tool {$toolname}' title='" . $tool->getDescription() . "'>" . $html . "</li>";
      break;   
    }

    return $html;
  }

  // --------------------------------------------------------------

  /**
   * Register a Tool to Display on the Toolbar
   *
   * @param Tools\Tool $toolObj;
   * @return boolean
   */
  public function registerTool($toolObj) {

    if ( ! ($toolObj instanceOf Tools\Tool)) {
      throw new InvalidArgumentException(get_class($toolObj) . " is not an instance of Devtoolbar\Tools\Tool");
    }

    $tmp = explode('\\', get_class($toolObj));
    $basename = end($tmp);
    $this->tools[$basename] = $toolObj;
    return TRUE;
  }

  // --------------------------------------------------------------

  /**
   * Register built-in tools in the Tools/ subdirectory
   *
   * @param array $skipTools  If any tool basename (e.g. Memory or Session) in this array, it will not be loaded
   * @return int  The number of tools loaded
   */
  private function registerBuiltinTools($skipTools = array()) {

    $toolDir = __DIR__ . DIRECTORY_SEPARATOR . 'Tools' . DIRECTORY_SEPARATOR;

    foreach (scandir($toolDir) as $file) {

      //Skip hidden and abstract classes and non-php files
      if ($file{0} == '.' OR $file == 'Tool.php' OR substr($file, -4) != '.php') {
        continue;
      }

      $baseName = substr($file, 0, -4);
      $className = 'Devtoolbar\\Tools\\' . $baseName;

      if (class_exists($className) && ( ! in_array($baseName, $skipTools))) {
        $this->registerTool(new $className);
      }
    }

    return count($this->tools);
  }

}

/* EOF: Devtoolbar.php */