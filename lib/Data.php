<?php

// Данный класс должны наследовать классы, связанные с данными: пользователя, постов, комментариев. 

class Data 
{
    public function validateData() {
        foreach (get_object_vars($this) as $key => $val) {
            if (str_contains($key, 'valid') && !empty($val)) {
                return false;
                // echo "$key => $val <br>";
            }
        }
        return true;
    }

    public function load($mas) {
        foreach ($mas as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }    
        }
        return true;
    }

    public function rn2br($data) {
        return preg_replace('/\v+|\\\r\\\n/ui','<br/>', $data);
    }

    public function br2rn($data) {
        return preg_replace('/<br\/>/ui',"\r\n", $data);
    }

    public function format($date) {
        $date = new DateTime($date);
        $date = $date->format('d.m.Y H:i:s');
        return $date;
    }

    public function formatSQL($date) {
        $date = new DateTime($date);
        $date = $date->format('Y-m-d H:i:s');
        return $date;
    }
}

// $data = new Data();

// $str = 'how do<br/> you do';

// var_dump($str);

// var_dump($data->br2rn($str));
// var_dump($data->format('2000-12-01'));


