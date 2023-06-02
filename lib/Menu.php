<?php
class Menu 
{
    public $mas;
    public $response;
    public $user;
    public $defaultUserProfile;

    public function __construct($mas, $response, $user, $defaultUserProfile) {
        $this->mas = $mas;
        $this->response = $response;
        $this->user = $user;
        $this->defaultUserProfile = $defaultUserProfile;
    }
    
    public function nav($pageName) { 
        $res = '';
        $res .= '<aside id="colorlib-aside" role="complementary" class="js-fullheight"><nav id="colorlib-main-menu" role="navigation"><ul>';
		
        //Выведение аватарки
        if (!$this->user->isGuest && empty($this->user->is_block)) {
            
            $avatar = $this->user->avatar ?? $this->defaultUserProfile;

            $res .= '<img src="' . $avatar . '" class="img-fluid rounded-circle" style="width: 100px; height: 100px"> <br><br>';
        } 

            foreach($this->mas as $key => $val) {

                // Вывод никнейма
                if ($key == '' && !empty($this->user->login) && empty($this->user->is_block)) {
                    $res .= "<li>" . $this->user->login . "</li>";
                }

                // Кто какие странички видит
                if (!$this->user->isAdmin && $key == 'Пользователи') {
                    continue;
                } elseif (!$this->user->isGuest && is_array($val)) {
                    continue;
                } elseif ($this->user->isGuest && $key == 'Выход') {
                    continue;
                }

                if (is_array($val)) {
                    $res .= '<li>';
                    // $tmp = ''; непонятно зачем
                    foreach ($val as $key2 => $val2) {
                        $res .= "<a ";
                        if ($pageName == $val2) {
                            $res .= 'class="colorlib-active" ';
                        }
                        $res .= "href=" . $this->response->getLink($val2, []) . ">$key2</a>";

                        if ($key2 != array_key_last($val)) {
                            $res .= ' / ';
                        }

                    }
                    $res .= "</li>";
                    continue;
                }

                $res .= '<li ';
                if ($pageName == $val) {
                    $res .= 'class="colorlib-active"';
                }
                $res .= ">";
                $res .= "<a href=" . $this->response->getLink($val, []) . ">$key</a>";
                $res .= "</li>";
                
            }
        $res .= '</ul></nav></aside>';

        return $res;
    }
}
