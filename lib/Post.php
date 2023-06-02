<?php

class Post extends Data
{
    public $id;
    public $title;
    public $content;
    public $preview;
    public $create_at;
    public $update_at;
    public $id_user;
    public $picture_name;
    public $numComments;

    public $authorLogin;
    public $authorAvatar;

    public $validTitle;
    public $validContent;
    public $validPreview;

    public $user;
    
    public function __construct($user) {
        $this->user = $user;
        $this->id_user = $this->user->id;
        // var_dump($user);
    }

    public function validate() {
        if (empty($this->title)) {
            $this->validTitle = 'Заполните поле!';
        }
        if (empty($this->content)) {
            $this->validContent = 'Заполните поле!';
        }
        if (empty($this->preview)) {
            $this->validPreview = 'Заполните поле!';
        }

        return $this->validateData();
    }

    public function load($mas) {
        // var_dump($this->user->request->post());
        // var_dump($this);
        parent::load($mas); 
        // var_dump($this); die;
    }

    public function save() {
        $this->content = $this->rn2br($this->content);
        $this->id_user = $this->user->id;

        if ($this->id) {
            $this->user->mysql->query("UPDATE `post` SET `title` = '$this->title', `content` = '$this->content', `preview` = '$this->preview', `update_at` = CURRENT_TIMESTAMP WHERE `id` = '$this->id'");
        } else {
            $this->user->mysql->query("INSERT INTO `post` (`title`, `content`, `preview`, `create_at`, `update_at`, `id_user`) VALUES ('$this->title', '$this->content', '$this->preview', CURRENT_TIMESTAMP, NULL, '$this->id_user')");
        }

        return true;
    }

    public function findOne($id) {
        $postData = $this->user->mysql->querySelect("SELECT * FROM post WHERE `id`=$id");
        if (empty($postData)) {
            return false;
        }
        $this->load($postData[0]);
        $this->numComments = (int) $this->user->mysql->querySelect("SELECT count(*) as numComments FROM comment WHERE `id_post`=$id")[0]['numComments'];
        // var_dump($this);
        return true;
    }

    public function formatDate($date) {
        return $this->format($date);
    }

    public function postList($limit = false, $offset = 0) {

        if (!$limit) {
            // Если лимита нет, выводим все посты
            $limit = $this->user->mysql->querySelect("SELECT count(id) as num FROM post")[0]['num'];
        }

        $postsMas = [];

        // достаем необходимые записи

        $last10Posts = $this->user->mysql->querySelect("SELECT * from post ORDER BY id DESC LIMIT $offset, $limit");

        // echo "<pre>";
        // var_dump($last10Posts); die;
        
        foreach ($last10Posts as $postMas) {
            $user = new User($this->user->request, $this->user->mysql);
            $user->identity($postMas['id_user']);
            $post = new static($user);
            $post->findOne($postMas['id']);
            array_push($postsMas, $post);
        }

        return $postsMas;
    }

    public function postList10() {
        return $this->postList(10, 0);
    }

    public function delete() {

        // Удаление комментариев
        $this->user->mysql->query("DELETE FROM `comment` WHERE `id_post` = '$this->id'");
        // Удаление поста
        if ($this->user->mysql->query("DELETE FROM `post` WHERE `id` = '$this->id'")) {
            if(file_exists("images/image_$this->id.jpg")) {
                unlink("images/image_$this->id.jpg");
            }
            return true;
        }
    }

    public function checkFile($formName) {
        return isset($_FILES[$formName]) && is_uploaded_file($_FILES[$formName]['tmp_name']);
    }

    public function saveFileImages($formName, $postId) {

        
        // $this->file = $_FILES[$formName];
        //Для придания уникальности названию файла:
        // $differ = basename($this->file['tmp_name'], '.tmp');
        
        // $fileName = 'images/' . $differ . basename($this->file['name']) ;
        
        $this->picture_name = "images/image_$postId.jpg";

        $this->user->mysql->query("UPDATE `post` SET `picture_name` = '$this->picture_name' WHERE `id`=$postId");
        // var_dump();
        $fromFile = $_FILES[$formName]['tmp_name'];

        if (move_uploaded_file($fromFile, $this->picture_name) ){
            $res = true;
        } else {
            $res = false;
        }
        return $res;
    }
}

