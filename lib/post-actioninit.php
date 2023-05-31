<?php
require_once 'init.php';

if (isset($_GET['id'])) {
    $post->findOne($_GET['id']);
}

if ($request->isPost && $user->role == 'author') {
    $post->load($request->post());
    // var_dump($post);
    if ($post->validate()) {
        // Чтобы не сохранять
        if ($post->save()) {
            $postId = $post->id ?? $user->mysql->querySelect("SELECT MAX(id) as id FROM post")[0]['id'];
            if ($post->checkFile('picture')) {
                $post->saveFileImages('picture', $postId);
                // var_dump($_FILES);
                // var_dump($post);
            }
            // var_dump($postId);
            // var_dump($post);
            $response->redirect('post.php', ['id' => $postId]);
        }
    }
}



