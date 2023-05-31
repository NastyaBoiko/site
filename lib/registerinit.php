<?php
// echo "<pre>";
require_once 'init.php';

if ($request->isPost) {
    $user->load($request->post());
    // $user->validateRegister();
    // var_dump($user);
    if ($user->validateRegister()) {
        if ($user->save()) {
            $userId = $user->id ?? $user->mysql->querySelect("SELECT MAX(id) as id FROM user")[0]['id'];
            if ($user->checkFile('avatar')) {
                $user->saveFileImages('avatar', $userId);
                // var_dump($_FILES);
                // var_dump($post);
            }
            if ($user->login()) {
                header("Location: " . $response->getLink('index.php', []));
            }
        }
    }
}

// var_dump($user);



