<?php
function asmh_boot($class)
{
  require_once 'lib/utils.php';

  if (substr($class, 0, 5) == 'ASMH\\') {
    $filename = ASMH_PATH . '/lib/' . 
      strtolower(str_replace('\\', '/', substr($class, 5))) . '.php';

    if (file_exists($filename)) {
      require($filename);
    } else {
      $filename = ASMH_PATH . '/ui/' . 
        strtolower(str_replace('\\', '/', substr(str_replace('_', '-', $class), 5))) . '.php';

      if (file_exists($filename)) {
        require($filename);
      }
    }
  }
}

function asmh_init()
{
  spl_autoload_register('asmh_boot');
  add_action('init', array('\ASMH\Main', 'init'), 100, 0);
}

