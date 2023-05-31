<?php

require_once 'init.php';

if (isset($_GET['id_post']) && isset($_GET['id_parent'])) {
    // Загрузка ID поста и ID родительского комментария в новый коммент
    $comment->load($request->get());
    // Объект-комментарий родителя, identity - чтобы подгрузить пользователя, который создает комментарий
    $parentComment->findOneComment($_GET['id_parent']);
    // $parentComment->post->user->identity($parentComment->id_user);
    // echo "<pre>";
    // var_dump($user);
    // Данные юзера, создавшего родительский комментарий - если подгружать юзера - передача по ссылке
    $parentComment->authorLogin = $user->mysql->querySelect("SELECT login FROM user where `id`='$parentComment->id_user'")[0]['login'];
    $parentComment->authorAvatar = $user->mysql->querySelect("SELECT avatar FROM user where `id`='$parentComment->id_user'")[0]['avatar'];
    // var_dump($parentComment);


} else {
    $response->redirect('posts.php', []);
}

// Создание и сохранение ответа на комментарий
if ($request->isPost && $user->role == 'author') {
    $comment->load($request->post());
    // $comment->load($request->post());
    // var_dump($comment);
    if ($comment->validate()) {
        // var_dump($comment);
        // Чтобы не сохранять
        if ($comment->save()) {
            $response->redirect('post.php', ['id' => $comment->id_post]);
        }
    }

}