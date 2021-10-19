<?php
define('BASEPATH', '');
include_once '../application/config/database.php';
date_default_timezone_set('Asia/Kolkata');

define('ENABLE_DATABASE', true);
define('DATABASE_HOST', $db['default']['hostname']);
define('DATABASE_USERNAME', $db['default']['username']);
define('DATABASE_PASSWORD', $db['default']['password']);
define('DATABASE_DB', $db['default']['database']);

define('DBENVIRONMENT1', $db['default']['DBENVIRONMENT']);
define('WS', $db['default']['WS']);
define('WEBSOCKET_SERVER_IP', $db['default']['WEBSOCKET_SERVER_IP']);
define('WEBSOCKET_SERVER_PORT', $db['default']['WEBSOCKET_SERVER_PORT']);
define('CRT_PATH', $db['default']['CRT_PATH']);
define('KEY_PATH', $db['default']['KEY_PATH']);
define('CA_PATH', $db['default']['CA_PATH']);
define('IF_SSL', $db['default']['IF_SSL']);
// echo KEY_PATH;