<?php
$configs = include('config.php');

$client = require_once __DIR__ . '/cognito.php';
include_once __DIR__ . '/static/header.html';



#printf('<section class="box"><pre><font color="red">This is some text!</font></section>');

#echo $user->get('Username');
#echo $recaptca_url;

/*
	$user->changePassword('oldPassword', 'newPassword', function(err, result) {
        if (err) {
            alert(err);
            return;
        }
        console.log('call result: ' + result);
    });
*/




include_once __DIR__ . '/static/footer.html';
?>





			
			
