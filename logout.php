<?php

require_once 'lib/init.php';

$user->logout();

$response->redirect('index.php');