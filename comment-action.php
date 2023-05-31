<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";
// var_dump($post->picture_name);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?= $header->create($post->title)?>
	
</head>

<body>
	<div id="colorlib-page">
		<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
		<?php 
			echo $menu->nav(basename(__FILE__));
		?>
		
		<div id="colorlib-main">
			<section class="ftco-no-pt ftco-no-pb">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 px-md-5 py-1">
							<!-- Сверху некрасиво удаление и редактирование -->
							<!-- <div>
								<a href="" class="text-warning" style="font-size: 1.8em;" title="Редактировать">🖍</a>
								<a href="" class="text-danger" style="font-size: 1.8em;" title="Удалить">🗑</a>
							</div> -->

							<div class="comments pt-4 mt-2">
								<h3 class="mb-5 font-weight-bold">Ответ на комментарий</h3>
								<ul class="comment-list">
									
									<li class="comment">
										<!-- avatar -->
										<?php if (!empty($parentComment->authorAvatar)):?>
											<div class="vcard bio">
												<img src="<?=$parentComment->authorAvatar?>" alt="avatar">
											</div>
										<?php endif;?>
										
										<div class="comment-body">
											<div class="d-flex justify-content-between">
												<h3><?=$parentComment->authorLogin?></h3>

												
											</div>
											<div class="meta"><?=$parentComment->post->format($parentComment->create_at)?></div>
											<p>
												<?=$parentComment->comment?>
											</p>
											<!-- <p><a href="#" class="reply">Ответить</a></p> -->
										</div>
									</li>

								</ul>
								<!-- END comment-list -->

								<div class="comment-form-wrap pt-2">
									<h3 class="mb-5">Ответьте на комментарий</h3>
									<form action="#" method="post" class="p-1 p-md-5 bg-light">
										<div class="form-group">
											<label for="message">Сообщение</label>
											<textarea name="comment" id="message" cols="20" rows="5"
												class="form-control <?=$comment->validComment ? 'is-invalid' : '';?>"></textarea>
											<div class="invalid-feedback">
												<?= $comment->validComment;?>
											</div>
										</div>

										<div class="form-group">
											<input type="submit" value="Отправить" name="send_comment"
												class="btn py-3 px-4 btn-primary">
										</div>
									</form>
								</div>


								
							</div>
						</div>
					</div><!-- END-->
				</div>
			</section>
		</div><!-- END COLORLIB-MAIN -->
	</div><!-- END COLORLIB-PAGE -->

	<!-- loader -->
	<?= file_get_contents('lib/preloader.html');?>


	<?= file_get_contents('lib/script.html');?>


</body>

</html>