<?php
$configs = include('config.php');
$client = require_once __DIR__ . '/cognito.php';
include_once __DIR__ . '/static/header.html';




if (!empty($_POST['old_password']) && !empty($_POST['new_password'])) {
    try {
        
        if ($_POST['new_password'] == $_POST['confirm_password'] ) {

			
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

				$client->changePassword([
					'AccessToken' => $_SESSION['user.accessToken'], // REQUIRED
					'PreviousPassword' => $_POST['old_password'], // REQUIRED
					'ProposedPassword' => $_POST['new_password'], // REQUIRED
				]);
				
			
				try {
					$client->globalSignOut(['AccessToken' => $_SESSION['user.accessToken']]);
				} catch (Exception $e) {
				} finally {
					session_destroy();
				}
			
			
				header("Location: login.php?chpass_success=true");			

			
			}else{

				printf('<section class="box"><pre><font color="red">Please verify captcha</font></section>');
			}			
			
			
			
			
			
			
        
        }else{
			printf('<section class="box"><pre><font color="red">Error confirm password</font></section>');
			
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
			<h2>Change Password</h2>
			

		</header>
		<div class="box">
			<form method="post" action="chpass.php">
				
					
				
				<div class="row uniform 50%">
					<div class="12u">
						
						<input type="password" name="old_password" id="old_password" 
						value="" placeholder="Old Password" required/>
												
					</div>
				</div>
				
				<div class="row uniform 50%">
					<div class="12u">
						
						<input type="password" name="new_password" id="password" 
						value="" placeholder="New Password" required/>
												
					</div>
				</div>
			
				<div class="row uniform 50%">
					<div class="12u">
						
						<input type="password" name="confirm_password" id="password" 
						value="" placeholder="Confirm New Password" required/>
												
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
							<li><input type="submit" value="Change Password" /></li>
							
						</ul>
					</div>
				</div>
				
			</form>
			
		</div>
	</section>




<?php
include_once __DIR__ . '/static/footer.html';
?>





			
			
