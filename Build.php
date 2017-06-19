<?php

//No users will see this page. It is only for building the pages. Error reporting should probably be turned on in production.
error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!file_exists('plugins/Config.php')){die('Please create config file from sample.');}
include('plugins/Config.php');
include('pluigns/Loader.php');
Loader('plugins');

Loader('example');

Event('Build');

echo '<p>Done! <a href="/">Home</a></p>';
