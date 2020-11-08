<?php 
//model
spl_autoload_register(function($class) {
    $filename = str_replace('\\', '/', $class) . '.php';
    require($filename);
});

class sort {

    static function open_page ($page, $posts) {
        $count = post::select_count_posts();
        for ($id=$count; $id>0; $id--) {
            if (($posts[$id]->page == $page)&&(!empty($posts[$id]->id))) {
                controller::publish_post($posts[$id]);
            }
        }
    }

    static function sort_str ($posts, $method, $orientation) {
        if (empty($orientation)) $orientation = 'rise';
        $count = post::select_count_posts();
        for ($id_post=1; $id_post<$count+1; $id_post++) { 
            for ($id_before=1; $id_before<$count+1; $id_before++) {
                $req = ($orientation == 'rise') ? $posts[$id_before]->$method < $posts[$id_post]->$method : $posts[$id_before]->$method > $posts[$id_post]->$method;
                if ($req) {
                    $smt = $posts[$id_post];
                    $posts[$id_post] = $posts[$id_before];
                    $posts[$id_before] = $smt;
                }
            }
        }
        echo 'Sort by '.$method.' and '.$orientation.'<br>';
        return $posts;
    }

    static function sort_status ($posts, $status) {
        $count = post::select_count_posts();
        for ($i=1; $i<$count+1; $i++) {
            if ($posts[$i]->status != $status) {
                unset($posts[$i]);
            }
        }
        echo $status ? 'Sort by decided' : 'Sort by undecided';
        return $posts;
    }
}