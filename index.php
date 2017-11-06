<?php
require_once("lib/init.php");
echo($clientToken = Braintree_ClientToken::generate());
?>