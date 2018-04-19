<?php
$configs = include('config.php');
$client = require_once __DIR__ . '/cognito.php';
include_once __DIR__ . '/static/header.html';


if (!empty($_POST['email'])) {
    try {

		
			$data = array(
				'secret' => $conf_recaptca_server_key,
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

				$reset_email = $_POST['email'];
				
				$client->forgotPassword([
						'ClientId' => $conf_aws_clientId,
						'Username' => $reset_email,
					]);
					
				header("Location: confirm.php?reset_email=".$reset_email);				

			
			}else{

				printf('<section class="box"><pre><font color="red">Please verify captcha</font></section>');
			}			
		
		
		
    } catch (\Aws\Exception\AwsException $e) {
        #printf('<pre><code>%s</code></pre>', $e->getAwsErrorMessage());
		printf('<section class="box"><pre><font color="red">%s</font></section>', $e->getAwsErrorMessage());
    }
	
}


?>

<!-- Main -->
	<section id="main" class="container 75%">
		<header>
			<h2>Reset Password</h2>
			<!--<p>Tell us what you think about our little operation.</p>-->
		</header>
		<div class="box">
			<form method="post" action="reset.php" enctype="multipart/form-data">
				
				<div class="row uniform 50%">
					<div class="12u">
						<input type="email" name="email" id="email" value="" placeholder="Email" required/>
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
							<li><input type="submit" value="Reset Password" /></li>
							
						</ul>
					</div>
				</div>
				
			</form>
			
		</div>
	</section>




<?php
include_once __DIR__ . '/static/footer.html';
?>





			
			
