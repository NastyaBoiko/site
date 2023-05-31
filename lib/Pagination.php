<?php

class Pagination
{
    public $user;
    public $post;
    public $page;
    public $postsOnPage = 3;

    public function __construct($user, $post, $response) {
        $this->user = $user;
        $this->post = $post;
        $this->response = $response;
    }

    public function getPosts($postsOnPage = 3) {
        $this->postsOnPage = $postsOnPage;
        $this->getPage();
        // Первая скобочка - сколько постов на странице, вторая - сколько постов пропустить
        return $this->post->postList($this->postsOnPage, ($this->page - 1) * $this->postsOnPage);
    }

    public function getPage() {
        if (isset($_GET['page'])) {
            $this->page = $_GET['page'];
        } else {
            $this->page = 1;
        }
    }

    public function create() {
        $this->getPage();
        //сколько слева и справа кружочков
        $step = 2;

        $count = (int) $this->user->mysql->querySelect("SELECT COUNT(*) as count FROM post")[0]['count'];
        $pagesCount = ceil($count / $this->postsOnPage);
        // var_dump($pagesCount); die;
        $res = '';
        $res .= '<div class="row"><div class="col"><div class="block-27"><ul>';

        if ($this->page == 1) {
            $res .= '<li><a href="#">&lt;</a></li>';
        } else {
            $prev = $this->page - 1;
            $res .= "<li><a href=" . $this->response->getLink('posts.php', ['page' => $prev]) . ">&lt;</a></li>";
        }

        // var_dump($pagesCount);
        //Создание прокрутки
        if ($pagesCount > $step * 2 + 1) {
            if ($this->page > $step && $this->page < $pagesCount - $step) {
                $start = $this->page - $step;
                $end = $this->page + $step;
            } elseif ($this->page < $step + 1) {
                $start = 1;
                $end = $start + $step * 2;
            } elseif ($this->page > $pagesCount - ($step + 1)) {
                $start = $pagesCount - $step * 2;
                $end = $pagesCount;
            }
        } else {
            $start = 1;
            $end = $pagesCount;
        }

        for ($i = $start; $i < $end + 1; $i ++) {
            
            $res .= "<li";
            if ($this->page == $i) {
                $res .= " class='active'><span>$i</span>";
            } else {
                $res .= "><a href=" . $this->response->getLink('posts.php', ['page' => $i]) . ">$i</a>";
            }

            $res .= "</li>";
        }
            // <li class="active"><span>1</span></li>
            // <li><a href="#">2</a></li>
            // <li><a href="#">3</a></li>
            // <li><a href="#">4</a></li>
            // <li><a href="#">5</a></li>

        if ($this->page == $pagesCount) {
            $res .= '<li><a href="#">&gt;</a></li>';
        } else {
            $next = $this->page + 1;
            $res .= "<li><a href=" . $this->response->getLink('posts.php', ['page' => $next]) . ">&gt;</a></li>";
        }
        // $res .= '<li><a href="#">&gt;</a></li>';
        $res .= '</ul></div></div></div>';
        return $res;
    }
}

