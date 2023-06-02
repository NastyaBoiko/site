<?php

require_once 'init.php';

if (isset($_GET['user_id']) && isset($_GET['unblock'])) {
    $admin->unblock($_GET['user_id']);
}

if (isset($_GET['user_id']) && isset($_GET['blockforever'])) {
    $admin->blockforever($_GET['user_id']);
    // Перезагрузка для отсутствия GET-параметров
    $response->redirect('users.php', []);
}