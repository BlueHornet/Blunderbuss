<?php

ini_set('output_buffering', 'off');
ini_set('zlib.output_compression', false);
ini_set('display_errors', true);
ini_set('implicit_flush', true);
ob_implicit_flush(true);

set_time_limit(0);

header('Cache-Control: no-cache');
header('Content-type: text/plain');

require_once('Blunderbuss.php');

// Allow execution from CLI
if (php_sapi_name() == 'cli') {
    $_REQUEST = $_SERVER;
}
ob_start();

echo "Using relay host " . $_REQUEST['relayHost'] . "\n\n";
ob_flush();
flush();

$blast = new Blunderbuss(array('streamOutput' => true, 'host' => $_REQUEST['relayHost'], 'user' => $_REQUEST['relayUser'], 'pass' => $_REQUEST['relayPass']));
$results = $blast->load($_REQUEST['messageData'])->send();
