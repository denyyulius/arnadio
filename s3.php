<?php
$configs = include('config.php');
require 'aws.phar';

use Aws\CognitoIdentity\CognitoIdentityClient;
use Aws\Credentials\Credentials;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

global $user;

session_start();

		
        $client = new CognitoIdentityProviderClient([
          'version' => $conf_aws_cognito_version,
          'region' => $conf_aws_cognito_region,
		  'credentials' => array(
				'key' => $conf_aws_cognito_key,
				'secret'  => $conf_aws_cognito_secret,
			  )
        ]);
		
		
if (!empty($_SESSION['user.accessToken'])) {
    try {
        $user = $client->getUser(['AccessToken' => $_SESSION['user.accessToken']]);
    } catch (\Exception $e) {
        
		session_destroy();
		
    }
}


return $client;