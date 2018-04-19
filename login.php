<?php
$configs = include('config.php');
$client = require_once __DIR__ . '/cognito.php';
include_once __DIR__ . '/static/header.html';




if (!empty($_POST['email'])) {
    try {
        
        if (!empty($_POST['password']) ) {
            
			
			$result = $client->adminInitiateAuth([
                'AuthFlow' => 'ADMIN_NO_SRP_AUTH',
                'UserPoolId' => $conf_aws_cognito_poolID,
                'ClientId' => $conf_aws_clientId,
                'AuthParameters' => [
                    'USERNAME' => $_POST['email'],
                    'PASSWORD' => $_POST['password'],
                ],
            ]);

            $accessToken = $result->get('AuthenticationResult')['AccessToken'];
            $_SESSION['user.accessToken'] = $accessToken;

            #header("Location: index.php?success=true");
			header("Location: generic.php");
        
        }
    } catch (\Aws\Exception\AwsException $e) {
		
		printf('<section class="box"><pre><font color="red">%s</font></section>', $e->getAwsErrorMessage());

    }
}



if(isset($_GET['chpass_success']) && $_GET['chpass_success']!=""){
	if ($_GET['chpass_success'] == 'true'){
		printf('<section class="box"><pre><font color="green">Password Successfully Changed</font></section>');
	}
}

if(isset($_GET['reset_pass_success']) && $_GET['reset_pass_success']!=""){
	if ($_GET['reset_pass_success'] == 'true'){
		printf('<section class="box"><pre><font color="green">Password Reset Successfully</font></section>');
	}
}


?>

<!-- Main -->
	<section id="main" class="container 75%">
		<header>
			<h2>Login</h2>

		</header>
		<div class="box">
			<form method="post" action="login.php">
				
				<div class="row uniform 50%">
					<div class="12u">
						<input type="email" name="email" id="email" 
						
						value="<?php
							   
									if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
									{
									 echo $_REQUEST['email'];
									}

							   ?>" placeholder="Email" required/>
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

							   ?>" placeholder="Password" required/>
						<span class="pull-right"><a href="reset.php">Forget Password ?</a></span>
						
					</div>
				</div>

				<div class="row uniform">
					<div class="12u">
						<ul class="actions align-center">
							<li><input type="submit" value="Log In" /></li>
							
						</ul>
					</div>
				</div>
				</br><div class="align-center"><a href="signup.php">Create Account</a></div>
			</form>
			
		</div>
	</section>




<?php
include_once __DIR__ . '/static/footer.html';
?>





			
			
