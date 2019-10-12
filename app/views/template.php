<!--<html>-->
<!--<head>-->
<!--    <title>--><? //= $this->e($title) ?><!--</title>-->
<!--</head>-->
<!--<body>-->
<!---->
<? //= $this->section('content') ?>
<!---->
<!--</body>-->
<!--</html>-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">Project</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto<?php if ($_SESSION['auth_logged_in']) echo ' d-none'; ?>">
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register">Register</a>
                    </li>
                </ul>


                <div class="dropdown<?php if (!$_SESSION['auth_logged_in']) echo ' d-none'; ?>">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['auth_username']; ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="profile">Профиль</a>
                        <a class="dropdown-item" href="logout">Выход</a>
                    </div>
                </div>


            </div>
        </div>
    </nav>

    <?php if ($this->section('comments')): ?>
        <?= $this->section('comments') ?>
    <?php endif ?>

    <?php if ($this->section('loginForm')): ?>
        <?= $this->section('loginForm') ?>
    <?php endif ?>

    <?php if ($this->section('registerform')): ?>
        <?= $this->section('registerform') ?>
    <?php endif ?>

    <?php if ($this->section('dataUser')): ?>
        <?= $this->section('dataUser') ?>
    <?php endif ?>

    <?php if ($this->section('adminComments')): ?>
        <?= $this->section('adminComments') ?>
    <?php endif ?>
</div>
</body>
</html>