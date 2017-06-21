<?php

//No users will see this page. It is only for building the pages. Error reporting should probably be turned on in production.
error_reporting(E_ALL);
ini_set('display_errors', '1');

include('plugins/Loader.php');

global $App;
$App = array(
  'APP_FAVICON' => '',
  'APP_TITLE'   => 'Draupnir.io',
  'HEAD'        => '',
  'NAV_LEFT'    => '',
  'NAV_RIGHT'   => ''
);

Loader('plugins');

Loader('example-homepage');

Event('Build');

echo '<p>Done! <a href="/">Home</a></p>';
