<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";
// var_dump($admin);
// var_dump($admin->userBlock->login);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?= $header->create('Блокировка пользователя')?>

</head>

<body>
	<div id="colorlib-page">
		<?php 
			require_once 'lib/init.php';
			echo $menu->nav(basename(__FILE__));
		?>

		<div id="colorlib-main">
			<section class="contact-section px-md-2  pt-5">
				<div class="container">
					<div class="row d-flex contact-info">
						<div class="col-md-12 mb-1">
							<h2 class="h3">Временная блокировка пользователя</h2>
							<div>
								Пользователь: <?=$admin->userBlock->login?>
							</div>
						</div>
					</div>
					<div class="row block-9">
						<div class="col-lg-6 d-flex">
							<form action="#" method="POST" class="bg-light p-5 contact-form">
								<div class="form-group">
									<label for="date-block">Дата временной блокировки</label>
									<input type="text" class="form-control" id="date-block" name="block_time" value=""
										required>
								</div>
								<div class="form-group">
									<input type="submit" value="Блокировать" class="btn btn-primary py-3 px-5">
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

	<script src="css/moment.min.js"></script>
	<script src="css/daterangepicker.js"></script>
	<script>
		$(document).ready(function () {
			$(function () {
				$('#date-block').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					timePicker: true,
					timePicker24Hour: true,
					minYear: 2023,
					maxYear: parseInt(moment().format('YYYY'), 10),
					locale: {
						format: 'DD.MM.YYYY HH:mm'
					}
				});
			});
		})
		$('#date-block').on('apply.daterangepicker', function (ev, picker) {
			$(this).val(picker.startDate.format('DD.MM.YYYY HH:mm'))
		});
	</script>
</body>
</html>