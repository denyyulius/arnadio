<?php
$configs = include('config.php');
$client = require_once __DIR__ . '/cognito.php';
include_once __DIR__ . '/static/header.html';

if (!empty($_POST['email'])) {

	
	if ($_POST['password'] == $_POST['confirm_password']) {
			
			$data = array(
				'secret' => $conf_recaptca_server_key ,
				'response' => $_POST["g-recaptcha-response"]
			);
			$options = array(
				'http' => array (
					'method' => 'POST',
					'content' => http_build_query($data)
				)
			);
			$context  = stream_context_create($options);
			$verify = file_get_contents($conf_recaptca_url, false, $context);
			$captcha_success=json_decode($verify);
			
			
			if ($captcha_success->success==true) {

				$client->signUp([
					'ClientId' => $conf_aws_clientId,
					'Username' => $_POST['email'],
					'Password' => $_POST['password'],
					'UserAttributes' => [[
						'Name' => 'email',
						'Value' => $_POST['email'],
					]],
				]);

				header("Location: info.php?signup=success");				

			
			}else{

				printf('<section class="box"><pre><font color="red">Please verify captcha</font></section>');
			}
			

	}else{
		
		#printf('<pre><code>Error confirm password</code></pre>');
		printf('<section class="box"><pre><font color="red">Error confirm password</font></section>');
	}
}



?>

<!-- Main -->
	<section id="main" class="container 75%">
		
		<header>
			<h2>Sign Up</h2>
		</header>
		
		<div class="box">
			<form method="post" action="signup.php">
				
				<div class="row uniform 50%">
					<div class="12u">
						<input type="email" name="email" id="email" value="" placeholder="Email" required/>
					</div>
				</div>							
				
				<div class="row uniform 50%">
					<div class="12u">
						<input type="password" name="password" id="password" value="" placeholder="Password" required/>
															
					</div>
				</div>
				
				<div class="row uniform 50%">
					<div class="12u">
						<input type="password" name="confirm_password" id="confirm_password" value="" placeholder="Confirm Password" required/>
															
					</div>
				</div>		
				
				<div class="row uniform 50%">
					<div class="12u">
						<div class="g-recaptcha" data-sitekey="<?php echo $conf_recaptca_client_key ?>"></div>	
					</div>
				</div>	
				
				<div class="row uniform">
					<div class="12u">
						<ul class="actions align-center">
							<li><input type="submit" value="Sign Up" /></li>
							
						</ul>
					</div>
				</div>
				</br><div class="align-center"><a href="login.php">Already Registered?</a></div>
			</form>
			
		</div>
	</section>




<?php
include_once __DIR__ . '/static/footer.html';
?>





			
			
