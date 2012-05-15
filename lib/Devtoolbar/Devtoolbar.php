<?php

namespace Devtoolbar;

class Devtoolbar {

  private $this_dir;

  public function __construct() {
    $this->dir = __DIR__ . DIRECTORY_SEPARATOR;
    $this->registerBuiltinTools();
  }

  public function render($withStyleAndJs = FALSE) {

    $html = ($withStyleAndJs) ? $this->renderStyleAndJs : '';
    $html .= "<div id='devtoolbarbg'>&nbsp;</div>";
    $html .= "<div id='devtoolbar'><ul><li>aaseawef</li><li>asdfasdfaqwef</li><li>aeq asdf </li><li>basdfaf</li></ul></div>";
    return $html;
  }

  public function renderStyleAndJs() {

    $html = '';
    $html .= "<style type='text/css'>" .  file_get_contents($this->dir . 'style.css') . "\n</style>\n";
    $html .= "<script type'text/js'>" . file_get_contents($this->dir . 'scripts.js') . "\n</script>\n";

    return $html;
  }

  /**
   * Register a Tool to Display on the Toolbar
   *
   * @param Tools\Tool $toolObj;
   * @return boolean
   */
  public function registerTool($toolObj) {

    var_dump($toolObj instanceOf Tools\Tool);

  }

  private function registerBuiltinTools() {

    $toolDir = __DIR__ . DIRECTORY_SEPARATOR . 'Tools' . DIRECTORY_SEPARATOR;

    foreach (scandir($toolDir) as $file) {

      //Skip hidden and abstract classes and non-php files
      if ($file{0} == '.' OR $file == 'Tool.php' OR substr($file, -4) != '.php') {
        continue;
      }

      $className = 'Tools\\' . substr($file, 0, -4);
      if (class_exists($className)) {
        $this->registerTool($className);
      }
    }
  }

}

/* EOF: Devtoolbar.php */