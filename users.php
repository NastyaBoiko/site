<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?= $header->create('Пользователи')?>
	
</head>

<body>
	<div id="colorlib-page">
		<?php 
			require_once 'lib/init.php';
			echo $menu->nav(basename(__FILE__));
		?>

		<div id="colorlib-main">
			<section class="contact-section px-md-4 pt-5">
				<div class="container">
					<div class="row block-9">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-md-12 mb-1">
									<h3 class="h3">Пользователи</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 mb-1">
									<table class="table table-striped">
										<thead>
											<tr>
												<th scope="col">#</th>
												<th scope="col">Name</th>
												<th scope="col">Surname</th>
												<th scope="col">Login</th>

												<th scope="col">E-mail</th>
												<th scope="col">Temp block</th>
												<th scope="col">Permanent block</th>
											</tr>
										</thead>
										<tbody>
											
											<?php
												$numberUser = 1;
												// var_dump();
												foreach ($admin->getUsersInfo() as $userData):
													if ($user->id == $userData->id) {
														continue;
													}
													// var_dump($userData->id); die;
											?>
											<tr>
												<th scope="row"><?=$numberUser?></th>
												<td><?=$userData->name?></td>
												<td><?=$userData->surname?></td>
												<td><?=$userData->login?></td>
												<td><?=$userData->email?></td>
												<td>
													<?php 
														if (empty($userData->is_block)) {
													
														echo "<a href=" . $response->getLink('temp-block.php', ['user_id' => $userData->id]) . " class='btn btn-outline-warning px-4'>⏳ Block</a>";

														} else {
															if ($userData->block_time) {
																echo $user->format($userData->block_time);
															} else {
																echo 'Заблокирован навсегда';
															}
														} 
													?>
												</td>
												<td>
													<?php 
														if (empty($userData->is_block)) {
															echo "<a href=" . $response->getLink('users.php', ['user_id' => $userData->id, 'blockforever' => '1']) . " class='btn btn-outline-danger px-4'>📌 Block</a>";
													
														} else { 
															if ($userData->block_time) {
																echo "<a href=" . $response->getLink('users.php', ['user_id' => $userData->id, 'unblock' => '1']) . " class='btn btn-outline-danger px-4'>Разблокировать</a>";
															} 
													
														}
													?>
												</td>
											</tr>
											<?php $numberUser++;
											endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
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