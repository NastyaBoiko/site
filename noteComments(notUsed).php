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
    
    <div class="comment-body mt-3">
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
        <p><a href="<?=$response->getLink('comment-action.php', ['id_post' => $comment->id_post, 'id_parent' => $comment->id]);?>" class="reply">Ответить</a></p>

        <!-- Ответ на коммент -->
        <?php 
            $answerComment = $comment->commentList($comment->id);
            if (!empty($answerComment)):
                foreach ($answerComment as $answer):
        ?>
        <!-- avatar -->
        
        <div class="comment-body mt-3">
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