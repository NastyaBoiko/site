<?php

class Comment extends Data
{
    public $id;
    public $id_parent;
    public $create_at;
    public $comment;
    public $id_post;
    public $id_user;

    public $authorLogin;
    public $authorAvatar;

    public $validComment;

    public $post;

    public function __construct($post) {
        // Юзер внутри
        $this->post = $post;
        if (isset($_GET['id'])) {
            $this->id_post = $_GET['id'];
        }
        $this->id_user = $this->post->user->id;
        // var_dump($this);
    }

    public function load($mas) {
        // var_dump($this->user->request->post());
        // var_dump($this);
        parent::load($mas); 
        // var_dump($this); die;
    }

    public function validate() {
        if (empty($this->comment)) {
            $this->validComment = 'Заполните поле!';
        }

        return $this->validateData();
    }

    public function save() {
        $this->comment = $this->rn2br($this->comment);

        if (is_null($this->id_parent)) {
            $this->post->user->mysql->query("INSERT INTO `comment` (`create_at`, `comment`, `id_post`, `id_user`) VALUES (CURRENT_TIMESTAMP, '$this->comment', '$this->id_post', '$this->id_user')");
        } else {
            $this->post->user->mysql->query("INSERT INTO `comment` (`id_parent`, `create_at`, `comment`, `id_post`, `id_user`) VALUES ('$this->id_parent', CURRENT_TIMESTAMP, '$this->comment', '$this->id_post', '$this->id_user')");
        }


        return true;
    }

    public function findOneComment($id) {
        $comData = $this->post->user->mysql->querySelect("SELECT * FROM comment WHERE `id` = $id");
        if (empty($comData)) {
            return false;
        }
        $this->load($comData[0]);
        // var_dump($this);
        return true;
    }

    public function commentList($id_parent = NULL, $limit = false, $offset = 0) {

        // Если лимита нет, выводим все комментарии
        if (!$limit) {
            $limit = $this->post->user->mysql->querySelect("SELECT count(id) as num FROM comment")[0]['num'];
        }

        $commentsMas = [];

        // echo 'Hello!';

        // достаем последние комментарии
        // echo "<pre>";

        // var_dump($this);

        if (is_null($id_parent)) {
            $lastComments = $this->post->user->mysql->querySelect("SELECT * from comment WHERE id_post ='$this->id_post' AND ISNULL(id_parent) ORDER BY id DESC LIMIT $offset, $limit");
        } else {
            $lastComments = $this->post->user->mysql->querySelect("SELECT * from comment WHERE id_post ='$this->id_post' AND id_parent = '$id_parent' ORDER BY id DESC LIMIT $offset, $limit");
        }

        // echo "<pre>";
        // var_dump($lastComments); die;
        
        foreach ($lastComments as $commentMas) {
            $user = new User($this->post->user->request, $this->post->user->mysql);
            $user->identity($commentMas['id_user']);
            $post = new Post($user);
            $post->findOne($commentMas['id_post']);
            $comment = new static($post);
            $comment->findOneComment($commentMas['id']);
            array_push($commentsMas, $comment);
        }

        // var_dump($commentsMas); die;

        return $commentsMas;
    }


    public function delete($id) {
        return $this->post->user->mysql->query("DELETE FROM `comment` WHERE `id` = $id");
    }
}

