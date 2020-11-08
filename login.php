<?php 

spl_autoload_register(function($class) {
    $filename = str_replace('\\', '/', $class) . '.php';
    require($filename);
});


if (isset($_COOKIE['auth']) && ($_COOKIE['auth'] == 'true')) {

    setcookie('auth','',time()-3600);

} else {

    setcookie('auth','false');
    
    $log = $_POST['log'];
    $pass = $_POST['pass'];

    if (($log == 'admin')&&($pass == '123')){
        setcookie("auth", 'true'); 
    } else {
        header('Location: index.php?alert=Data not available');
        exit;
    }

}

header('Location: index.php');
exit;

?>