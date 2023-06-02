<?php
require_once 'init.php';

if ($request->isPost) {
    $user->load($request->post());
    if ($user->validateLogin()) {
        // $user->login();
        // var_dump($user);
        if ($user->login()) {
            $response->redirect('index.php', []);
        }
    }
} 



