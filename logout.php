<?php
/** @var \Aws\CognitoIdentityProvider\CognitoIdentityProviderClient $client */
$client = require_once __DIR__ . '/cognito.php';

try {
    $client->globalSignOut(['AccessToken' => $_SESSION['user.accessToken']]);
} catch (Exception $e) {
} finally {
    session_destroy();
}

header('Location: index.php');