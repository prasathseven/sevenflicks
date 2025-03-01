<?php
require 'vendor/autoload.php';

use Google\Client;

$client = new Client();
$client->setClientId('1035288999394-3ssefqki293crmjuumbqcc28cmiaup0p.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/my%20seven/google-login.php');
$client->addScope('https://www.googleapis.com/auth/cloud-platform');

// Generate authentication URL
$authUrl = $client->createAuthUrl();
echo "<a href='$authUrl'>Login with Google</a>";
?>
