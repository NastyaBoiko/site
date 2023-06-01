<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?= $header->create('Лента постов')?>
</head>

<body>

	<div id="colorlib-page">
		<?php 
		require_once 'lib/init.php';
		echo $menu->nav(basename(__FILE__));
		?>
		
		<div id="colorlib-main">
			<section class="ftco-no-pt ftco-no-pb">
				<div class="container">
					<div class="row d-flex">
						<div class="col-xl-8 col-md-8 py-5 px-md-5">
							<div class="row">
								<div class="col-md-12 col-lg-12">
									<div>
										<?php if ($user->role == 'author'): ?>
										<a href="<?= $response->getLink('post-action.php', []); ?>" class="btn btn-outline-success">📝 Создать пост</a>
										<?php endif;?>
									</div>
								</div>
							</div>
							<div class="row pt-md-4">
								<!-- один пост/превью -->
								<?php 
									$contentPost = $pagination->getPosts(2);
									// echo "<pre>";
									// var_dump($contentPost); die;
									foreach ($contentPost as $post) {
								
								?>


								<div class="col-md-12 col-xl-12">
									<div class="blog-entry ftco-animate d-md-flex">
										<!--изображение для поста -->
										<?php if (!empty($post->picture_name)):?>
											<a href="<?=$response->getLink('post.php', ['id' => $post->id]);?>" class="img img-2" style="background-image: url(<?=$post->picture_name?>);"></a> 
										<?php endif;?>

										
										<div class="text text-2 pl-md-4">
											<h3 class="mb-2"><a href="<?=$response->getLink('post.php', ['id' => $post->id]);?>"><?=$post->title?></a></h3>
											<div class="meta-wrap">
												<p class="meta">
													<!-- <img src='avatar.jpg' /> -->
													<span class="text text-3"><?=$post->user->login?></span>
													<span><i class="icon-calendar mr-2"></i><?=$post->create_at?></span>
													<span><i class="icon-comment2 mr-2"></i><?=$post->numComments?> Comment</span>
												</p>
											</div>
											<p class="mb-4"><?=$post->preview?></p>
											<div class="d-flex pt-1  justify-content-between">
												<div>
												<a href="<?=$response->getLink('post.php', ['id' => $post->id]);?>" class="btn-custom">
													Подробнее... <span class="ion-ios-arrow-forward"></span></a>
												</div>	
												<?php 
												if ($post->id_user == $user->id || $user->isAdmin):?> 
													<div>
														<?php
														if ($post->id_user == $user->id):?> 
															<a href="<?=$response->getLink('post-action.php', ['id' => $post->id]);?>" class="text-warning" style="font-size: 1.8em;" title="Редактировать">🖍</a>
														<?php endif;?>

														<a href="<?=$response->getLink('post.php', ['id' => $post->id, 'deletePost' => '1']);?>" class="text-danger" style="font-size: 1.8em;" title="Удалить">🗑</a>
													</div>
												<?php endif;?>

											</div>
										</div>
									</div>
								</div>
								<?php 

									}
								
								?>



							</div><!-- END-->

							<!--pagination-->
							<?= $pagination->create()?>
							<!-- <div class="row">
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
							</div>  -->

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