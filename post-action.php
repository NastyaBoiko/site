<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";
// var_dump($_FILES);

// var_dump($post);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?= $header->create('Создание поста')?>
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
							<h2 class="h3">Создание поста</h2>
						</div>

					</div>
					<div class="row block-9">
						<div class="col-lg-6 d-flex">

							<form action="#" method="post" class="bg-light p-5 contact-form" enctype="multipart/form-data">
								<div class="form-group">
									<input type="text" class="form-control <?= $post->validTitle ? 'is-invalid' : '';?>" placeholder="Название поста" name="title" value='<?= $post->title ?>'>
									<div class="invalid-feedback">
										<?= $post->validTitle;?>
									</div>

								</div>
								<div class="form-group">
									<input type="text" class="form-control <?= $post->validPreview ? 'is-invalid' : '';?>" placeholder="Превью поста" name="preview" value='<?= $post->preview ?>'>
									<div class="invalid-feedback">
										<?= $post->validPreview;?>
									</div>
								</div>

								
								<div class="form-group">
									<textarea cols="30" rows="10" class="form-control <?= $post->validContent ? 'is-invalid' : '';?>" placeholder="Текст" name="content"><?=$post->content ? $post->br2rn($post->content) : '';?></textarea> 
									<div class="invalid-feedback">
										<?= $post->validContent;?>
									</div>
								</div>
								<div class="form-group">
									<input type="file" class="form-control-file" name="picture">
								</div>
								
								<div class="form-group">
									<input type="submit" value="Создать пост" class="btn btn-primary py-3 px-5">
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