<?php

class Request 
{
    public $isGet;
    public $isPost;

    public function __construct() {
        $this->isGet = $_SERVER['REQUEST_METHOD'] == 'GET';
        $this->isPost = $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function cleanParam($param) {
        if(!is_array($param)) {
            $param = trim(strip_tags($param)); //очистка входного параметра
        }
        return $param;
    }

    public function cleanData($mas) {
        $newMas = [];
        foreach ($mas as $key => $val) {
            $newMas[$key] = $this->cleanParam($val);
        }
        return $newMas;
    }

    public function get($param = false) {
        if ($param) {
            if (array_key_exists($param, $_GET)) {
                $res = $this->cleanParam($_GET[$param]);
            } else {
                $res = '';
            }
        } else {
            $res = $this->cleanData($_GET);
        }
        return $res;
    }

    public function post($param = false) {
        if ($param) {
            if (array_key_exists($param, $_POST)) {
                $res = $this->cleanParam($_POST[$param]);
            } else {
                $res = '';
            }
        } else {
            $res = $this->cleanData($_POST);
        }
        return $res;
    }

    public function host() {
        return $_SERVER['HTTP_HOST'];
    }

    public function getToken() {
        $res = null;

        if (isset($_GET['token'])) {
            $res = $_GET['token'];
        }

        return $res;
    }
}
