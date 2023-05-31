<?php

require_once 'init.php';

if (isset($_GET['user_id']) && isset($_GET['unblock'])) {
    $admin->unblock($_GET['user_id']);
}