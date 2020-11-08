<?php
//controller
spl_autoload_register(function($class) {
    $filename = str_replace('\\', '/', $class) . '.php';
    require($filename);
});



class controller{

    public $posts = array();
    public $pages;

    public function create_arr_posts () {

        $count = post::select_count_posts();

        for ($id=$count; $id>0; $id--) {
            $this->posts[$id] =new post();
            $this->posts[$id]->select_post($id);
        }


    }

    public function set_num_page () {
        
        $page = 0;

        $count = post::select_count_posts();
        for ($id=$count; $id>0; $id--) {
            if (!empty($this->posts[$id]->id)){
                $page++;
                $this->posts[$id]->page = ceil($page/3);
            }
        }

        $this->pages = ceil($page/3);

    }

    public function make_page(){

        $a = true;
        $this->create_arr_posts($this->posts);
        $this->set_num_page($this->posts);


        if (isset($_GET['sort'])&&($_GET['sort'] != 'all')){
            $this->posts = sort::sort_str($this->posts, $_GET['sort'], $_GET['orientation']);
            $a = false;
        } 

        if (isset($_GET['status'])&&($_GET['status']!='undefinded')){
            $this->posts = sort::sort_status($this->posts, $_GET['status']);
            $a = false;
        }

        if ($a) {
            $count = count($this->posts);

            for ($id=$count; $id>0; $id--) {
                $this->posts[$id] =new post();
                $this->posts[$id]->select_post($id);
            }
        }

        $this->set_num_page($this->posts);

        if (isset($_GET['page'])&&($_GET['page']<=$this->pages)) { 
            $page = $_GET['page'];
        } else { 
            $page = 1;
        }

        sort::open_page($page, $this->posts);

    }

    public function navig () {

        if (isset($_GET['page'])&&($_GET['page']<=$this->pages)) { 
            $page = $_GET['page'];
        } else { 
            $page = 1;
        }

        for ($i=1; $i<$this->pages+1; $i++) {
            ?>
                <button type="submit" class="btn btn-secondary <?php if ($page == $i) echo 'active'; ?>" name="page" value="<?= $i ?>"><?= $i ?></button>
            <?php
        }
    }

    static function alert() {
        if (isset($_GET['alert'])) {

            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?= $_GET['alert']; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php

        }
    }

    static function get_post($value) {
        if (isset($_GET['alert'])) {
            $sql = "SELECT * FROM post WHERE id = '{$_GET["alert"]}'";
            $result = post::request($sql);
            if (!empty($result)){
                $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($posts as $post) {
                    if (!empty($post[$value])) {
                        echo $post[$value];
                    }
                }
            }
        } else {
            echo 'Ошибка';
        }
    }

    static function publish_post ($post) {
        if ($post->status) {
            $status = 'Решено';
        } else {
            $status = 'Не решено';
        }
        if ($post->changed) {
            $status = $status.'<br> Изменено администатором';
        }
        
        ?>
        <div class="card cart">
            <div class="card-body">
                <h5 class="card-title"><?=  $post->name ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $post->email ?></h6>
                <p class="card-text"><?= $post->text ?></p>
                <p class="card-link status<?= $post->status ?>"><?= $status ?></p>
                <form action="change.php?alert=<?= $post->id ?>" method="post">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Редактировать</button>
                </form>
            </div>
        </div>
        <?php
    }

    static function is_logined () {
        if (isset($_COOKIE['auth'])&&($_COOKIE['auth']!='false')) {
            ?>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Выйти</button>
            <?php
            return;
        }

        ?>
            <input class="form-control mr-sm-2" type="text" name="log" placeholder="Логин" aria-label="LogIn" pattern="^[a-zA-Z]+$" required>
            <input class="form-control mr-sm-2" type="password" name="pass" placeholder="Пароль" aria-label="Pass" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Войти</button>
        <?php
    }

    static function set_cookie () {

        if (isset($_GET['sort']) || isset($_GET['status'])) {
            setcookie("sort", '', time()-3600); 
            setcookie("status", '', time()-3600);
            setcookie("page", '', time()-3600); 
            setcookie("orientation", '', time()-3600); 
        } else {
            if ((!isset($_GET['sort']))&&(isset($_COOKIE['sort']))) $_GET['sort'] = $_COOKIE['sort'];
            if ((!isset($_GET['status']))&&(isset($_COOKIE['status']))) $_GET['status'] = $_COOKIE['status'];
            if ((!isset($_GET['page']))&&(isset($_COOKIE['page']))) $_GET['page'] = $_COOKIE['page'];
            if ((!isset($_GET['orientation']))&&(isset($_COOKIE['orientation']))) $_GET['orientation'] = $_COOKIE['orientation'];
        }
        if (isset($_GET['sort'])) setcookie("sort", $_GET['sort']); 
        if (isset($_GET['status'])) setcookie("status", $_GET['status']);
        if (isset($_GET['page'])) setcookie("page", $_GET['page']); 
        if (isset($_GET['orientation'])) setcookie("orientation", $_GET['orientation']); 
    }
}
?>