<?php

class User extends Data
{
    public $table = 'user';
    public $database = 'site';

    public $id;
    public $name;
    public $surname;
    public $patronymic;
    public $login;
    public $email;
    public $password;
    public $password_repeat;
    public $avatar;
    public $rules;

    public $validName;
    public $validSurname;
    public $validPatronymic = NULL;
    public $validLogin;
    public $validEmail;
    public $validPassword;
    public $validPassword_repeat;
    public $validRules;
    public $validBlock;

    public $block_time = NULL;
    public $is_block = 0;
    public $token = NULL;
    public $id_role = 2;

    public $loginAdmin = 'admin';
    public $passwordAdmin = 'admin';
    
    public $isGuest = true;
    public $isAdmin = false;
    public $role;

    public $request;
    public $mysql;

    public function __construct($request, $mysql) {
        $this->request = $request;
        $this->mysql = $mysql;
        if ($this->token = $this->request->getToken()) {
            $this->identity();
            // Автоматический выход из системы заблокированного пользователя
            $this->autoBlock();
            // var_dump($this);
        }
    }


    public function load($mas) {
        // foreach ($mas as $key => $val) {
        //     if (property_exists($this, $key)) {
        //         $this->$key = $val;
        //     }    
        // }
        $this->isGuest = false;

        parent::load($mas);

        if ($this->isAdmin()) {
            $this->isAdmin = true;
            $this->role = 'admin';
        } else {
            $this->role = 'author';
        }
    }

    public function validateRegister() {

        if (empty($this->name)) {
            $this->validName = 'Заполните поле!';
        }
        if (empty($this->surname)) {
            $this->validSurname = 'Заполните поле!';
        }
        if (empty($this->login)) {
            $this->validLogin = 'Заполните поле!';
        } elseif (!$this->mysql->isUnique('user', 'login', $this->login)) {
            $this->validLogin = 'Пользователь уже существует!';
        }
        if (empty($this->email)) {
            $this->validEmail = 'Заполните поле!';
        }
        if (empty($this->password)) {
            $this->validPassword = 'Заполните поле!';
        } elseif (mb_strlen($this->password) < 6) {
            $this->validPassword = 'Пароль должен содержать не менее 6 символов!';
        }
        if (empty($this->password_repeat)) {
            $this->validPassword_repeat = 'Заполните поле!';
        } elseif ($this->password_repeat != $this->password) {
            $this->validPassword_repeat = 'Пароли не совпадают!';
        }
        if ($this->rules != 'accept') {
            $this->validRules = 'Необходимо согласиться с правилами регистрации!';
        }

        return $this->validateData();

        // foreach (get_object_vars($this) as $key => $val) {
        //     if (str_contains($key, 'valid') && !empty($val)) {
        //         return false;
        //         // echo "$key => $val <br>";
        //     }
        // }

        // return true;
    }

    public function save() {
        return $this->mysql->query("INSERT INTO user(`name`, `surname`, `patronymic`, `login`, `email`, `password`, `token`, `id_role`) VALUES ('$this->name', '$this->surname', '$this->patronymic', '$this->login', '$this->email', '$this->password', '$this->token', '2')");
    }

    public function validateLogin() {
        if (empty($this->login)) {
            $this->validLogin = 'Заполните поле!';
        }
        if (empty($this->password)) {
            $this->validPassword = 'Заполните поле!';
        }

        return $this->validateData();

        // foreach (get_object_vars($this) as $key => $val) {
        //     if (str_contains($key, 'valid') && !empty($val)) {
        //         return false;
        //         // echo "$key => $val <br>";
        //     }
        // }

        // return true;
    }

    public function login() {
        // echo "<pre>";
        $dataMas = $this->mysql->querySelect("SELECT * FROM user WHERE `login` = '$this->login' and `password` = '$this->password'");
        // var_dump($this);
        if (empty($dataMas)) {
            // $this->isGuest = true;
            $this->validPassword = 'Неверные логин или пароль!';
            return false;
        } else {
            $this->load($dataMas[0]);
            // var_dump($this);

            // Проверка на заблокированного пользователя и его разблокировка если блокировка прошла

            if (!empty($this->is_block)) {
                if ($this->autoUnblock()) {
                    $this->setToken();
                    $this->mysql->query("UPDATE `user` SET `token` = '$this->token' WHERE `login` = '$this->login'");
                } else {
                    return false;
                }
            } else {
                $this->setToken();
                $this->mysql->query("UPDATE `user` SET `token` = '$this->token' WHERE `login` = '$this->login'");
            }

        }
        return true;
    }

    public function isAdmin() {
        return ($this->login == $this->loginAdmin && $this->password == $this->passwordAdmin) ? true : false;
    }

    public function setToken() {
        $token = '';
        $symb = [...range(0, 9), ...range('a', 'z'), ...range('A', 'Z')];

        for ($i = 0; $i < 15; $i++ ) {
            $token .= $symb[array_rand($symb)];
        }
        $this->token = $token;
        return $token;
    }

    public function identity($userId = false) {
        // Добавить выход из системы если заюлокирован во время сеанса
        if ($userId) {
            $dataMas = $this->mysql->querySelect("SELECT * FROM user WHERE `id` = '$userId'");
        } else {
            $dataMas = $this->mysql->querySelect("SELECT * FROM user WHERE `token` = '$this->token'");
        }
        if (!empty($dataMas)) {
            $this->load($dataMas[0]);
            return true;
        }
        return false;
    }

    public function autoBlock() {
        if ($this->is_block == 1) {
            $this->logout();
            header("Location: http://localhost/site/index.php");
            exit();
        }
    }

    public function logout() {
        if ($this->token) {
            $this->mysql->query("UPDATE `user` SET `token` = '' WHERE `login` = '$this->login'");
        }
    }

    //Для аватарки

    public function checkFile($formName) {
        return isset($_FILES[$formName]) && is_uploaded_file($_FILES[$formName]['tmp_name']);
    }

    public function saveFileImages($formName, $userId) {
        
        $this->avatar = "images/person_$userId.jpg";

        $this->mysql->query("UPDATE `user` SET `avatar` = '$this->avatar' WHERE `id`=$userId");
        // var_dump();
        $fromFile = $_FILES[$formName]['tmp_name'];

        if (move_uploaded_file($fromFile, $this->avatar) ){
            $res = true;
        } else {
            $res = false;
        }
        return $res;
    }

    // Разблокировка пользователя при входе

    public function unblock($userId) {
        return $this->mysql->query("UPDATE `user` SET `block_time` = NULL, `is_block` = 0 WHERE `id`=$userId");
    }

    public function autoUnblock() {
        if (new DateTime($this->block_time) < new DateTime()) {
            $this->unblock($this->id);
        } else {
            $this->validBlock = "Пользователь заблокирован до $this->block_time";
            return false;
        }
        return true;
    }
}

// $userData = [
//     'name' => 'Nastya',
//     'surname' => 'Mishka',
//     'email' => 'mulo',
//     'login' => 'myLogin',
//     'password' => 'myPasswrd',
//     'password_repeat' => 'myPassword',

// ];

// $user = new User();

// echo '<pre>';

// $user->load($userData);

// // var_dump($user);

// var_dump($user->validateRegister());

// var_dump($user);