<?php
    header("Content-Type: text/html; charset=utf-8");
	spl_autoload_register(function($class) {
		$filename = str_replace('\\', '/', $class) . '.php';
		require($filename);
    });
    controller::set_cookie();
    //view 
?>
<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        Задачник
    </title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css"></link>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body> 
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Задачник</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Сортировка
                    </a>
                    <div class="dropdown-menu my_drop" aria-labelledby="navbarDropdown">

                        <form action="index.php" method="get">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="exampleRadios0"  name="sort" value="all">
                                <label class="form-check-label" for="exampleRadios0">
                                    По новизне
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort" id="exampleRadios1" value="name">
                                <label class="form-check-label" for="exampleRadios1">
                                    Имя 
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort" id="exampleRadios2" value="email">
                                <label class="form-check-label" for="exampleRadios2">
                                    Почта   
                                </label>
                            </div>
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="orientation" id="exampleRadios1" value="rise">
                                <label class="form-check-label" for="exampleRadios1">
                                    По возрастанию 
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="orientation" id="exampleRadios2" value="reduct">
                                <label class="form-check-label" for="exampleRadios2">
                                    По убыванию 
                                </label>
                            </div>
                            <hr/>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="exampleRadios3"  name="status" value="undefinded">
                                <label class="form-check-label" for="exampleRadios3">
                                    Все
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="exampleRadios4" value="1">
                                <label class="form-check-label" for="exampleRadios4">
                                    Решенные задачи
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="exampleRadios5" value="0">
                                <label class="form-check-label" for="exampleRadios5">
                                    Нерешенные задачи
                                </label>
                            </div>
                            <br>
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Применить</button>
                        </form>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="login.php" method="post">

                <?php

                    controller::is_logined();

                ?>
            <br>
            </form>
        </div>
</nav>

       
<div class="block"> 

    <?php
        controller::alert();
    ?>

    <h2 class="card-title">Новая задача</h2>
    <form action="create_post.php" method="POST">
        <div class="form-group">
            <label for="exampleFormControlInput1">Имя</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" pattern="^[a-zA-ZА-Яа-я]+$" required>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput2">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleFormControlInput2" placeholder="name@example.com" required>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Текст задачи</label>
            <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3" required></textarea>
        </div>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Создать задачу</button>
    </form>
</div>
<div class="block">
    <h2 class="card-title">Задачи</h2>

    <?php 

        $contr = new controller();
        $contr->make_page();

    ?>

    <form action="index.php" method="get">
        <div class="btn-group" role="group" aria-label="First group">

        <?php 

            $contr->navig();

        ?>

        </div>
    </form>

</div>
</body>