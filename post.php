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
						<div class="col-lg-12 px-md-5 py-5">
							<!-- Сверху некрасиво удаление и редактирование -->
							<!-- <div>
								<a href="" class="text-warning" style="font-size: 1.8em;" title="Редактировать">🖍</a>
								<a href="" class="text-danger" style="font-size: 1.8em;" title="Удалить">🗑</a>
							</div> -->

							<div class="post">
								<h1 class="mb-3"><?=$post->title?></h1>
								<div class="meta-wrap">
									<p class="meta">
										<!-- <img src='images/person_1.jpg' /> -->
										<span class="text text-3"><?=$post->authorLogin?></span>
										<span><i class="icon-calendar mr-2"></i><?=$post->format($post->create_at)?></span>
										<span><i class="icon-comment2 mr-2"></i><?=$post->numComments?> Comment</span>
									</p>
								</div>
								<?=$post->content?>
								<p>
									<img src="<?=$post->picture_name?>" alt="" class="img-fluid">
								</p>
								<?php
									if ($post->id_user == $user->id):
								?>
								<div>
									<a href="<?=$response->getLink('post-action.php', ['id' => $post->id]);?>" class="text-warning" style="font-size: 1.8em;"
										title="Редактировать">🖍</a>
									<a href="<?=$response->getLink('post.php', ['id' => $post->id, 'deletePost' => '1']);?>" class="text-danger" style="font-size: 1.8em;" title="Удалить">🗑</a>
								</div>

								<?php
									endif;
								?>

							</div>
							<div class="comments pt-5 mt-5">
								<h3 class="mb-5 font-weight-bold"><?=$post->numComments?> комментариев</h3>
								<ul class="comment-list">
									<?php 
										$commentInfo = $comment->commentList();
										// echo "<pre>";
										// var_dump($commentInfo); die;
										foreach ($commentInfo as $comment):
									
									?>
									<li class="comment">
										<!-- avatar -->
										<?php if (!empty($comment->post->user->avatar)):?>
											<div class="vcard bio">
												<img src="<?=$comment->post->user->avatar?>" alt="avatar">
											</div>
										<?php endif;?>
										
										<div class="comment-body">
											<div class="d-flex justify-content-between">
												<h3><?=$comment->post->user->login?></h3>

												<?php if ($comment->id_user == $user->id || $user->isAdmin):?>
													<a href="<?=$response->getLink('post.php', ['id' => $post->id, 'deleteCom' => $comment->id]);?>" class="text-danger" style="font-size: 1.8em;" title="Удалить">🗑</a>
												<?php endif;?>
												
											</div>
											<div class="meta"><?=$comment->post->format($comment->create_at)?></div>
											<p>
												<?=$comment->comment?>
											</p>
											<p><a href="<?=$response->getLink('comment-action.php', ['id_post' => $post->id, 'id_parent' => $comment->id]);?>" class="reply">Ответить</a></p>

											<!-- Ответ на коммент -->
											<?php 
												// var_dump($comment);
												// var_dump($comment->answerCommentList($comment->id));

												$answerComment = $comment->commentList($comment->id);
												if (!empty($answerComment)):
													foreach ($answerComment as $answer):
											?>
											<!-- avatar -->
											
											<div class="comment-body mt-4">
													<?php if (!empty($answer->post->user->avatar)):?>
														<div class="vcard bio">
															<img src="<?=$answer->post->user->avatar?>" alt="avatar">
														</div>
													<?php endif;?>

													<div class="d-flex justify-content-between">
														<h3><?=$answer->post->user->login?></h3>

														<?php if ($answer->id_user == $user->id || $user->isAdmin):?>
															<a href="<?=$response->getLink('post.php', ['id' => $post->id, 'deleteCom' => $answer->id]);?>" class="text-danger" style="font-size: 1.8em;" title="Удалить">🗑</a>
														<?php endif;?>
														
													</div>
													<div class="meta"><?=$answer->post->format($answer->create_at)?></div>
													<p>
														<?=$answer->comment?>
													</p>
													<!-- <p><a href="<?=$response->getLink('comment-action.php', ['id_post' => $post->id, 'id_parent' => $answer->id]);?>" class="reply">Ответить</a></p> -->
												</div>
											<?php 
													endforeach;
												endif;?>
											
										</div>
									</li>

									<?php endforeach;?>
									
								</ul>
								<!-- END comment-list -->
								<?php 
								//Комментировать может только человек со статусом автор, но не автор поста
								if ($user->role == 'author' && $post->id_user !== $user->id):?>
								<div class="comment-form-wrap pt-5">
									<h3 class="mb-5">Оставьте комментарий</h3>
									<form action="#" method="post" class="p-3 p-md-5 bg-light">
										<div class="form-group">
											<label for="message">Сообщение</label>
											<textarea name="comment" id="message" cols="30" rows="10"
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
								<?php endif;?>


								
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