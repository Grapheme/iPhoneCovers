<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('twillio.php'); 
 
$account_sid = 'AC72e30afc147349566a7783cb3bbf4253'; 
$auth_token = 'b8a62d4ecb80e52cb00ebe4db50aa5e5'; 
$client = new Services_Twilio($account_sid, $auth_token); 

$sms = $client->account->sms_messages->create(
    "+17322424781", // From this number
    $_POST['phonenum'], // To this number
    'Твой чехол готов, можешь забрать его в зоне CHE'
);