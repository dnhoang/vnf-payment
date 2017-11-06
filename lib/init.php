<?php
session_start();
require_once("autoload.php");

Braintree\Configuration::environment('sandbox');
Braintree\Configuration::merchantId('xsvch4w2f5b7wnqp');
Braintree\Configuration::publicKey('nkr7z436h8rtbyrt');
Braintree\Configuration::privateKey('ab0774f38f8fe82d5f537c8c20896c18');
?>