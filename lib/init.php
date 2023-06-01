<?php

require_once 'autoload.php';
require_once 'config.php';

$request = new Request();

$mysql = new MySql($sql);

$user = new User($request, $mysql);

$post = new Post($user);

$response = new Response($user);

$menu = new Menu($config, $response, $user);

$header = new Header();

$pagination = new Pagination($user, $post, $response);

$comment = new Comment($post, $response);

$parentComment = new Comment($post, $response);

$admin = new Admin($request, $mysql);

// var_dump($user);


// echo "<pre>";
// var_dump($admin->getUsersInfo()); die;

// var_dump($pagination->getPosts(0,3));
// echo $pagination->create();

// echo "<pre>";
// $post->postList(); die;



