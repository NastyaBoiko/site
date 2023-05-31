<?php

require_once 'init.php';

// Загрузка поста и комментариев к нему
if (isset($_GET['id'])) {
    $post->findOne($_GET['id']);
    $comment->post->findOne($_GET['id']); 
    // echo "<pre>";
    // var_dump($comment);
    $post->authorLogin = $user->mysql->querySelect("SELECT login FROM user where `id`='$post->id_user'")[0]['login'];
    // var_dump($post);
} else {
    header("Location: " . $response->getLink('index.php', []));
    exit();
}

// var_dump($_GET);
//Удаление поста
if (isset($_GET['deletePost']) && isset($_GET['id'])) {
    if ($post->delete()) {
        $response->redirect('posts.php', []);
    }
    // var_dump($post);
}


//Создание комментария
if ($request->isPost && $user->role == 'author') {
    // var_dump($request->post());

    $comment->load($request->post());

    if ($comment->validate()) {
        // var_dump($comment);
        // Чтобы не сохранять
        if ($comment->save()) {
            $response->redirect('post.php', ['id' => $comment->id_post]);
        }
    }
}

//Удаление комментария
if (isset($_GET['deleteCom'])) {
    // var_dump($comment); die;
    // var_dump($_GET['deleteCom']); die;
    if ($comment->delete($_GET['deleteCom'])) {
        $response->redirect('post.php', ['id' => $post->id]);
    }
}

// var_dump($post); die;

