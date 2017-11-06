<?php
require_once("lib/init.php");

$res = array();
$res['token'] =  Braintree_ClientToken::generate();

header('Content-Type: application/json');
echo json_encode($res);
?>