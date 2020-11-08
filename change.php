<?php
    header("Content-Type: text/html; charset=utf-8");
	spl_autoload_register(function($class) {
		$filename = str_replace('\\', '/', $class) . '.php';
		require($filename);
    });
    
    if (!isset($_COOKIE['auth']) || ($_COOKIE['auth'] == 'false')) {
            header('Location: index.php?alert=Have no root');
            exit;
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        Редактировать задачу
    </title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css"></link>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
    
<div class="block"> 

    <h2 class="card-title">Редактировать задачу</h2>
    <form action="create_post.php" method="POST">
        <div class="form-group">
            <label for="exampleFormControlInput1">Имя</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" pattern="^[a-zA-ZА-Яа-я]+$" value="<?php controller::get_post('name'); ?>" required></input>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput2">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleFormControlInput2" placeholder="name@example.com" value="<?php controller::get_post('emailadress'); ?>" required></input>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Текст задачи</label>
            <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3" value="" required><?php controller::get_post('text'); ?></textarea>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status" value="1">
            <label class="form-check-label" for="exampleCheck1">Решено</label>
        </div>
        <input type="hidden" name='id' value="<?php controller::get_post('id'); ?>">
        <br>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Готово</button>
    </form>
</div>

</body>
</html>