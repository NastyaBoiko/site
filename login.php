<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?= $header->create('Вход')?>
</head>

<body>
	<div id="colorlib-page">
		<?php 
			echo $menu->nav(basename(__FILE__));
		?>

		<div id="colorlib-main">
			<section class="contact-section px-md-2  pt-5">
				<div class="container">
					<div class="row d-flex contact-info">
						<div class="col-md-12 mb-1">
							<h2 class="h3">Авторизация</h2>
						</div>
					</div>
					<div class="row block-9">
						<div class="col-lg-6 d-flex">
							<form action="#" method="post" class="bg-light p-5 contact-form">
								<div class="form-group">
									<input type="text" class="form-control <?= $user->validLogin ? 'is-invalid' : '';?>" placeholder="Your Login"
										name="login" value='<?= $user->login?>'>
									<div class="invalid-feedback">
										<?= $user->validLogin;?>
									</div>
								</div>

								<div class="form-group">
									<input type="password" class="form-control <?= $user->validPassword ? 'is-invalid' : '';?> <?= $user->validBlock ? 'is-invalid' : '';?>" placeholder="Password"
										name="password">
									<div class="invalid-feedback">
										<?= $user->validPassword;?>
										<?= $user->validBlock;?>
									</div>
								</div>
								<div class="form-group">
									<input type="submit" value="Вход" class="btn btn-primary py-3 px-5">
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div><!-- END COLORLIB-MAIN -->
	</div><!-- END COLORLIB-PAGE -->

	<!-- loader -->
	<?= file_get_contents('lib/preloader.html');?>

	<?= file_get_contents('lib/script.html');?>


</body>

</html>