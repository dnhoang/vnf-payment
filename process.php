<?php
require_once("lib/init.php");

$nonce = $_POST["nonce"];
$amount = $_POST["amount"];
$order_id = $_POST["order_id"];

if(empty($nonce) || empty($amount) || empty($order_id)){
    $res['success'] = false;
    $res['message'] = 'Required fields: nonce, amount, order_id';
    
    header('Content-Type: application/json');
    echo json_encode($res);
    exit();
}

$result = Braintree_Transaction::sale([
  'amount' => $amount,
  'paymentMethodNonce' => $nonce,
  "orderId" => $order_id,
  'options' => [
    'submitForSettlement' => True
  ]
]);

$now = new DateTime();
$res = array();

if ($result->success) {
    $settledTransaction = $result->transaction;
    $res['success'] = true;
    $res['message'] = 'Payment success.';
    $res['transaction_id'] = $result->transaction->id;
    
    file_put_contents('logs/success-logs-' . $now->format('Y-m-d') . '.txt', $now->format('Y-m-d H:i:s') . PHP_EOL .  $settledTransaction . PHP_EOL . "-------------------------------------" . PHP_EOL, FILE_APPEND | LOCK_EX);
} else {
    $res['success'] = false;
    $res['message'] = $result->message;
    
    file_put_contents('logs/error-logs-' . $now->format('Y-m-d') . '.txt', $now->format('Y-m-d H:i:s') . PHP_EOL . print_r($result->errors->deepAll(), true) . PHP_EOL . "-------------------------------------" . PHP_EOL, FILE_APPEND | LOCK_EX);
}



header('Content-Type: application/json');
echo json_encode($res);
?>