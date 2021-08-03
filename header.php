<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <title><?=$title?></title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
    <?
    session_start();
    ?>
    <script src="//ulogin.ru/js/ulogin.js"></script>
<!-- навигация -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP-intern</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?
                    $menu_hello = $_SESSION["user"]["name"];
                    if( empty($_SESSION['user']) ){
                        echo '<li class="nav-item">
                        <a class="nav-link" href="auth.php">Авторизация</a>
                        </li>';
                        echo '<li class="nav-item">
                        <a class="nav-link" href="reg.php">Регистрация</a>
                        </li>';
                        
                    } else {
                        
                        echo "<li class='nav-item dropdown'>
                             <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                             Здравствуйте, $menu_hello!
                             </a>
                             <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                             <li><a class='dropdown-item' href='account.php'>Личный кабинет</a></li>
                             <li><hr class='dropdown-divider'></li>
                             <li><a class='dropdown-item' href='handlers/exit.php'>Выйти</a></li>
                             </ul>
                             </li>";
                        
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>