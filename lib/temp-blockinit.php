<?php

require_once 'init.php';

// Находим пользователя, которого блокируем
if (isset($_GET['user_id'])) {
    $admin->findUserBlock($_GET['user_id']);
    // var_dump($admin);
}
// echo "<pre>";
// var_dump($_POST);



if ($request->isPost && $user->role == 'admin') {
    // var_dump($request->post());
    
    $admin->load($request->post());
    // var_dump($admin);

    // Чтобы не сохранять
    if ($admin->block()) {
        $response->redirect('users.php', []);
    }
}