<?php

class Response
{
    public $user;

    public function __construct($user) {
        $this->user = $user;

        if (isset($_GET['token']) && $this->user->isGuest) {
            // var_dump($this->user);
            header("Location: http://localhost/site/index.php");
            exit();
        }
    }

    public function getLink($url, $urlMas) {
        if (!$this->user->isGuest && !array_key_exists('token', $urlMas)) {
            $urlMas['token'] = $this->user->token;
        }

        if (!strpos($url, '?') && !empty($urlMas)) {
            $url = $url . '?';
        }

        foreach ($urlMas as $key =>$val) {
            $url .= "$key=$val";
            if ($key != array_key_last($urlMas)) {
                $url .= '&';
            }
        }
        
        return $url;
    }

    public function redirect($url, $urlMas = []) {
        //Проверка в logininit
        $url = $this->getLink($url, $urlMas);
        $host = $this->user->request->host();

        header("Location: http://$host/site/$url");
        exit();

        return true;
    }
}