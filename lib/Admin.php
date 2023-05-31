<?php

class Admin extends User
{
    public $userBlock;

    public $block_time;

    public function __construct($request, $mysql) {
        parent::__construct($request, $mysql);
    }

    public function getUsersInfo() {
        $usersInfo = $this->mysql->querySelect("SELECT * from user ORDER BY id");

        // Массив для помещения объектов-юзеров
        $users = [];

        foreach ($usersInfo as $userInfo) {
            $user = new User($this->request, $this->mysql);
            $user->identity($userInfo['id']);
            // Автоматическая разблокировка пользователя
            $this->autoUnblockAdmin($user);
            array_push($users, $user);
        }

        return $users;
    }

    // Для вывода информации о юзере где блокировка (login)

    public function findUserBlock($id) {
        $this->userBlock = new User($this->request, $this->mysql);
        $this->userBlock->identity($id);
    }

    public function block() {
        $userId = $this->userBlock->id;
        $this->block_time = $this->formatSQL($this->block_time);
        // var_dump($this->block_time); die;
        return $this->mysql->query("UPDATE `user` SET `block_time` = '$this->block_time', `is_block` = 1 WHERE `id`=$userId");
    }

    public function unblock($userId) {
        return $this->mysql->query("UPDATE `user` SET `block_time` = NULL, `is_block` = 0 WHERE `id`=$userId");
    }

    public function autoUnblockAdmin($user) {
        if (!is_null($user->block_time)) {
            if (new DateTime($user->block_time) < new DateTime()) {
                $this->unblock($user->id);
            } else {
                return false;
            }
        }
        return true;
    }
}