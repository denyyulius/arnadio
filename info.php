<?php
$client = require_once __DIR__ . '/cognito.php';
include_once __DIR__ . '/static/header.html';

?>

<!-- Main -->
	<section id="main" class="container 75%">
		<header>
			
			<?php
			
				if (isset($_GET['signup'])) {
					if ($_GET['signup']=='success'){
						?>
						
							<h2>Sign Up Sucessfull</h2></br>
							<h3>Please check your email to continue</h3>

						
						<?php
					}

				}
			?>	


		</header>
		
	</section>




<?php
include_once __DIR__ . '/static/footer.html';
?>





			
			
