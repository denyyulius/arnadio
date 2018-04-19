<?php
$configs = include('config.php');
$client = require_once __DIR__ . '/cognito.php';
include_once __DIR__ . '/static/header.html';


if (!empty($_POST['email'])) {
    try {
        
        if (!empty($_POST['password']) ) {
			
			$client->confirmForgotPassword(['ClientId' => $conf_aws_clientId, 'ConfirmationCode' => $_POST['code'], 'Username' => $_POST['email'], 'Password' => $_POST['password']]);
			
			header("Location: login.php?reset_pass_success=true");
        
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
			<h2>Confirm Reset Password</h2>
			<h3>Please check your email for verification code</h3>

		</header>
		<div class="box">
			<form method="post" action="confirm.php">
				
				<div class="row uniform 50%">
					<div class="12u">
					
										
						<input type="email" name="email" id="email" 
						
						value="<?php
							   
									if(isset($_GET['reset_email']) && $_GET['reset_email']!="")
									{
									 echo $_GET['reset_email'];
									}

							   ?>" placeholder="Email" readonly/>
					</div>
				</div>							
				
				<div class="row uniform 50%">
					<div class="12u">
						
						<input type="password" name="password" id="password" 
						value="<?php
							   
									if(isset($_REQUEST['password']) && $_REQUEST['password']!="")
									{
									 echo $_REQUEST['password'];
									}

							   ?>" placeholder="New Password" required/>
												
					</div>
				</div>
				
				
				<div class="row uniform 50%">
					<div class="12u">
						
						<input type="text" name="code" id="code" 
						value="<?php
							   
									if(isset($_REQUEST['code']) && $_REQUEST['code']!="")
									{
									 echo $_REQUEST['code'];
									}

							   ?>" placeholder="Verification Code from Email" required/>
												
					</div>
				</div>				
				

				<div class="row uniform">
					<div class="12u">
						<ul class="actions align-center">
							<li><input type="submit" value="Confirm" /></li>
							
						</ul>
					</div>
				</div>
				
			</form>
			
		</div>
	</section>




<?php
include_once __DIR__ . '/static/footer.html';
?>





			
			
