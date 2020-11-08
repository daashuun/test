<?php
//controller
spl_autoload_register(function($class) {
    $filename = str_replace('\\', '/', $class) . '.php';
    require($filename);
});

for ($i = 0; $i < strlen($_POST['text']); $i++) {
    $char = $_POST['text'][$i];
    $char = htmlspecialchars($char, ENT_SUBSTITUTE);
    $str = $str.$char;
}
$_POST['text'] = $str;


if (isset($_POST['id'])){
    (isset($_POST['status'])) ? $status = ", status = '{$_POST['status']}'" : $status = " "; 
    $sql = "UPDATE  post SET name = '{$_POST['name']}', emailadress = '{$_POST['email']}', text = '{$_POST['text']}', changed = 1".$status." WHERE id = '{$_POST['id']}' ;";
    post::request($sql);
} else {
    $post = new post();
    $post->name = $_POST['name'];
    $post->email = $_POST['email'];
    $post->text = $_POST['text'];
    $result = $post::create_db_row($post);
    if (!$result) return;
}
header('Location: index.php?alert=Succsessful publishing!');
exit;

?>