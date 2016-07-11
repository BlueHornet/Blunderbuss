<!DOCTYPE html>
<html>
<head>
    <title>Blunderbuss Send Log</title>
</head>
<body>
<h1>Blunderbuss Send Log</h1>
<pre>
<?php

ini_set('display_errors', true);
require_once('Blunderbuss.php');

// Allow execution from CLI
if (php_sapi_name() == 'cli') {
    $_REQUEST = $_SERVER;
}

echo "Using relay host " . $_REQUEST['relayHost'] . "\n";
$blast = new Blunderbuss(array('host' => $_REQUEST['relayHost'], 'user' => $_REQUEST['relayUser'], 'pass' => $_REQUEST['relayPass']));
$results = $blast->load($_REQUEST['messageData'])->send()->getResponses();

var_dump($results);

?>
</pre>
<input type="button" value="Back" onclick="javascript:window.history.back()" />
</body>
</html>