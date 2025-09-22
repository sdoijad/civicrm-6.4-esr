<?php

// function to locate civicrm.settings.php

function get_conf_dir() {
  $confdir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'sites';


  $phpSelf = array_key_exists('PHP_SELF', $_SERVER) ? $_SERVER['PHP_SELF'] : '';
  $httpHost = array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : '';

  $uri = explode('/', $phpSelf);
  $server = explode('.', implode('.', array_reverse(explode(':', rtrim($httpHost, '.')))));
  for ($i = count($uri) - 1; $i > 0; $i--) {
    for ($j = count($server); $j > 0; $j--) {
      $dir = implode('.', array_slice($server, -$j)) . implode('.', array_slice($uri, 0, $i));
      if (file_exists("$confdir/$dir/civicrm.settings.php")) {
        $conf = "$confdir/$dir";
        return $conf;
      }
    }
  }
  $conf = "$confdir/default";
  return $conf;
}

$confPath = get_conf_dir();
if (file_exists($confPath . DIRECTORY_SEPARATOR . 'civicrm.settings.php' ) && !defined( 'CIVICRM_CONFDIR' )) {
  define('CIVICRM_CONFDIR', $confPath);
} else {
  $confPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'civicrm';
  if (file_exists($confPath . DIRECTORY_SEPARATOR . 'civicrm.settings.php') && !defined('CIVICRM_CONFDIR')) {
    define('CIVICRM_CONFDIR', $confPath);
  }
}
