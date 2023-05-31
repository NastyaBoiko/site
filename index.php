<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?= $header->create('Главная')?>

	<!-- <title>Информационная система - .....</title>
	<?= file_get_contents('lib/header.html');?> -->
</head>

<body>
	<div id="colorlib-page">
		<?php 
			echo $menu->nav(basename(__FILE__));
		?>
		<div id="colorlib-main">
			<section class="ftco-no-pt ftco-no-pb">
				<div class="container">
					<div class="row d-flex">
						<div class="col-xl-8 py-5 px-md-5">
							<div class="row pt-md-4">
								<!-- один пост/превью -->
								<?php 
									$contentPost = $post->postList10();
									// echo "<pre>";
									// var_dump($contentPost); die;
									foreach ($contentPost as $post) {

								?>


								<div class="col-md-12">
									<div class="blog-entry ftco-animate d-md-flex">
										<!-- изображение для поста--> 
										<?php if (!empty($post->picture_name)):?>
											<a href="<?=$response->getLink('post.php', ['id' => $post->id]);?>" class="img img-2" style="background-image: url(<?=$post->picture_name?>);"></a> 
										<?php endif;?>
										
										<div class="text text-2 pl-md-4">
											<h3 class="mb-2"><a href="single.php"><?=$post->title?></a></h3>
											<div class="meta-wrap">
												<p class="meta">
													<!-- <img src='avatar.jpg' /> -->
													<span class="text text-3"><?=$post->user->login?></span>
													<span><i class="icon-calendar mr-2"></i><?=$post->create_at?></span>
													<span><i class="icon-comment2 mr-2"></i><?=$post->numComments?> Comment</span>
												</p>
											</div>
											<p class="mb-4"><?=$post->preview?></p>
											<p><a href="<?= $response->getLink('post.php', ['id' => $post->id]);?>" class="btn-custom">Подробнее... <span
														class="ion-ios-arrow-forward"></span></a></p>
										</div>
									</div>
								</div>

								<?php 
									}
								?>

							</div><!-- END-->

							<!-- 
								pagination
								<div class="row">
								<div class="col">
									<div class="block-27">
										<ul>
											<li><a href="#">&lt;</a></li>
											<li class="active"><span>1</span></li>
											<li><a href="#">2</a></li>
											<li><a href="#">3</a></li>
											<li><a href="#">4</a></li>
											<li><a href="#">5</a></li>
											<li><a href="#">&gt;</a></li>
										</ul>
									</div>
								</div>
							</div> -->

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