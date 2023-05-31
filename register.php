<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?= $header->create('Регистрация')?>
</head>

<body>

	<div id="colorlib-page">
		<?php 
			echo $menu->nav(basename(__FILE__));
		?>

		<div id="colorlib-main">
			<section class="contact-section px-md-2 pt-5">
				<div class="container">
					<div class="row d-flex contact-info">
						<div class="col-md-12 mb-1">
							<h2 class="h3">Регистрация</h2>
						</div>

					</div>
					<div class="row block-9">
						<div class="col-lg-6 d-flex">

							<form action="#" method="post" class="bg-light p-5 contact-form" enctype="multipart/form-data">
								<div class="form-group">
									<input type="text" class="form-control <?= $user->validName ? "is-invalid" : '';?> " placeholder="Your Name" name="name" value='<?=$user->name?>'>
									<div class="invalid-feedback">
										<?=$user->validName;?>
									</div>
								</div>
								<div class="form-group">
									<input type="text" class="form-control <?= $user->validSurname ? 'is-invalid' : '';?>" placeholder="Your Surname" name="surname" value='<?=$user->surname?>'>
									<div class="invalid-feedback">
										<?= $user->validSurname;?>
									</div>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Your Patronymic"
										name="patronymic" value='<?=$user->patronymic?>'>
								</div>
								<div class="form-group">
									<input type="text" class="form-control <?= $user->validLogin ? 'is-invalid' : '';?>" placeholder="Your Login"
										name="login" value='<?=$user->login?>'>
									<div class="invalid-feedback">
										<?= $user->validLogin;?>
									</div>
								</div>
								<div class="form-group">
									<input type="email" class="form-control <?= $user->validEmail ? 'is-invalid' : '';?>" placeholder="Your Email"
										name="email" value='<?= $user->email?>'>
									<div class="invalid-feedback">
										<?= $user->validEmail;?>
									</div>
								</div>
								<div class="form-group">
									<input type="password" class="form-control <?= $user->validPassword ? 'is-invalid' : '';?>" placeholder="Password"
										name="password">
									<div class="invalid-feedback">
										<?= $user->validPassword;?>
									</div>
								</div>
								<div class="form-group">
									<input type="password" class="form-control <?= $user->validPassword_repeat ? 'is-invalid' : '';?>" placeholder="Password repeat"
										name="password_repeat">
									<div class="invalid-feedback">
										<?= $user->validPassword_repeat;?>
									</div>
								</div>

								<div class="form-group">
									<input type="file" class="form-control-file" name="avatar">
								</div>

								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input <?= $user->validRules ? 'is-invalid' : '';?>" type="checkbox" value="accept"
											id="rules" aria-describedby="invalidCheck3Feedback" name="rules" <?= $user->rules ? 'checked' : '';?>>
										<label class="form-check-label" for="rules">
											Rules
										</label>
										<div id="rulesFeedback" class="invalid-feedback">
											<?= $user->validRules;?>
										</div>
									</div>
								</div>

								

								<div class="form-group">
									<input type="submit" value="Регистрация" class="btn btn-primary py-3 px-5">
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