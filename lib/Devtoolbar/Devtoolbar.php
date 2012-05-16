<?php

namespace Devtoolbar;

class Devtoolbar {

  const LISTITEM   = 1;
  const DETAILPANE = 2;

  private $this_dir;

  private $tools = array();

  public function __construct() {
    $this->dir = __DIR__ . DIRECTORY_SEPARATOR;
    $this->registerBuiltinTools();
  }

  // --------------------------------------------------------------

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

  public function renderStyleAndJs() {

    $html = '';
    $html .= "<style type='text/css'>" .  file_get_contents($this->dir . 'style.css') . "\n</style>\n";
    $html .= "<script type'text/js'>" . file_get_contents($this->dir . 'scripts.js') . "\n</script>\n";

    return $html;
  }

  // --------------------------------------------------------------

  public function renderNoTools() {
    return "<li class='notool'>No Tools Installed</li>";
  }

  // --------------------------------------------------------------

  public function renderTool($toolname, $tool, $which = self::LISTITEM) {

    $html  = '';

    switch ($which) {

      case self::DETAILPANE:
        $html .= "<div class='tooldetails details {$toolname}'>" . $tool->details . "</div>";
      break;
      case self::LISTITEM:
        $html .= "<span class='indicator'>" . $tool->indicator . "</span>";
        $html .= "<span class='caption'>". $tool->caption . "</span>";
        $html = "<li class='tool {$toolname}'>" . $html . "</li>";
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

  private function registerBuiltinTools() {

    $toolDir = __DIR__ . DIRECTORY_SEPARATOR . 'Tools' . DIRECTORY_SEPARATOR;

    foreach (scandir($toolDir) as $file) {

      //Skip hidden and abstract classes and non-php files
      if ($file{0} == '.' OR $file == 'Tool.php' OR substr($file, -4) != '.php') {
        continue;
      }

      $className = 'Devtoolbar\\Tools\\' . substr($file, 0, -4);

      if (class_exists($className)) {
        $this->registerTool(new $className);
      }
    }
  }

}

/* EOF: Devtoolbar.php */