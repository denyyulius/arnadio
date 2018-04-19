<?php
$configs = include('config.php');
$client = require_once __DIR__ . '/cognito.php';
use Aws\S3\S3Client;


//kalo session udah expire --> balikin ke index
if (empty($user)) {
	header("Location: index.php");
}


?>
	<html>
		<head>
			<title>Generic - Alpha by HTML5 UP</title>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
			<link rel="stylesheet" href="assets/css/main.css" />
			<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		
			<script src='https://www.google.com/recaptcha/api.js'></script>

		</head>
		<body>		
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1><a href="index.php">Alpha</a> by HTML5 UP</h1>
					<nav id="nav">
						<ul>
							<!--<li><a href="index.php">Home</a></li>-->
							<li>
								<a href="#" class="icon fa-angle-down"><span class="icon fa-user"></span>&nbsp;&nbsp; <?php echo $user->get('Username')?></a>
								<ul>
									<li><a href="chpass.php">Change Password</a></li>
									<li><a href="logout.php">Log Out</a></li>
									
								</ul>
							</li>
							
						</ul>
					</nav>
				</header>



<?php

	try {       

		
        if (isset($_FILES['file']) && !$_FILES['file']['size']==0) {
			
			// creates a client object, informing AWS credentials
			$clientS3 = S3Client::factory(array(
				'version' => $conf_aws_version,
				'region' => $conf_aws_region,
				'credentials' => array(
					'key' => $conf_aws_access_key,
					'secret'  => $conf_aws_access_secret,
				  )
			));
	 
			// putObject method sends data to the chosen bucket (in our case, teste-marcelo)
			$response = $clientS3->putObject(array(
				'Bucket' => $conf_aws_bucket_name,
				'Key'    => $_FILES['file']['name'],
				'SourceFile' => $_FILES['file']['tmp_name'],
				'Metadata' => array(
					'username' => $user->get('Username')
				)
			));
	 
			#$_SESSION['msg'] = "Object successfully posted, address <a href='{$response['ObjectURL']}'>{$response['ObjectURL']}</a>";
	 
			echo '<section class="box"><pre><font color="green">File '. $_FILES['file']['name'] .' uploaded successfully</font></section>';
	 

		}
 
        
 
    } catch(Exception $e) {

		printf('<section class="box"><pre><font color="red">%s</font></section>', $e->getMessage());
    }
	
	
?>



			<!-- Main -->

				<section id="main" class="container">
				
					<header>
						<h2>Welcome!</h2>
						<p>A generic page for every non-generic situation.</p>
						
					</header>

					
					<div class="box">

						<form method="post" action="generic.php" enctype="multipart/form-data">	
						
						
						
							<div class="row uniform 50%">
								<div class="4u 12u(narrower)">
									<input type="radio" id="priority-low" name="priority" checked>
									<label for="priority-low">Sales Order</label>
								</div>
								<!--
								<div class="4u 12u(narrower)">
									<input type="radio" id="priority-normal" name="priority">
									<label for="priority-normal">Delivery Order</label>
								</div>
								<div class="4u 12u(narrower)">
									<input type="radio" id="priority-high" name="priority">
									<label for="priority-high">Sales Invoice</label>
								</div>
								-->
							</div>
						
							
							<div class="row uniform 50%">
								<div class="12u align-center" >
									<pre>&nbsp;
									<input type="file" class="form-control-file align-center" name="file">
									</pre>
									
								</div>
							</div>	
							
							
							
							
							<div class="row uniform">
								<div class="12u">
									<ul class="actions align-center">
										<li><input type="submit" value="Upload" /></li>
										
									</ul>
								</div>
							</div>
							
						</form>
					
					
					
					
					
					</div>
					
					
				</section>

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
						<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</footer>

		</div>


		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollgress.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>