<?php 
//model
class post {
    public $id;
    public $name = '';
    public $email = '';
    public $text = '';
    public $changed = 0;
    public $status = 0;

    static function request ($sql) {
        $host = 'localhost';
        $database = 'f0484894_root'; 
        $user = 'f0484894_root'; 
        $password = 'kPXxz3W1'; 
        $link = mysqli_connect($host, $user, $password, $database);
        if (!$link) {
            echo mysqli_error($link);
            return false;
        } 
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo mysqli_error($link);
            mysqli_close($link);
            return false;
        } 
        mysqli_close($link);
        return $result;
    }

    static function select_count_posts () {
        $sql = "SELECT id FROM post;";
        $result = post::request($sql);
        $count = mysqli_fetch_all($result, MYSQLI_NUM);
        return end(end($count));
    }

    static function create_db_row ($post) {
        $sql = "INSERT INTO post (name, emailadress, text) VALUES ('{$post->name}', '{$post->email}', '{$post->text}');";
        return post::request($sql);
    }

    public function select_post ($id, $status=0) {
        $sql = "SELECT name, emailadress, text, status, changed FROM post WHERE id = '{$id}'".(($status) ? " AND status = '{$status}';" : ";");
        $result = post::request($sql);
        if (!empty($result)){
            $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($posts as $post) {
                if (!empty($post['name'])) {
                    $this->id = $id;
                    $this->name = $post['name'];
                    $this->email = $post['emailadress'];
                    $this->text = $post['text'];
                    $this->status = $post['status'];
                    $this->changed = $post['changed'];
                }
            }
        }
        
    }
}