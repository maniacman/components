<?php

namespace App\controllers;

use League\Plates\Engine;
use App;
use PDO;
use Delight\Auth\Auth;
use SimpleMail;

class HomeController
{
    private $templates;
    private $pdo;
    private $auth;

    public function __construct()
    {
        // Create new Plates instance
        $this->templates = new Engine('../app/views');
        $this->pdo = new PDO('mysql:host=localhost;dbname=blog2;charset=utf8;', 'root', '');
        $this->auth = new Auth($this->pdo);
    }

    public function index()
    {
        $db = new App\QueryBuilder();
        $comments = $db->getAllowedComments();

        // Render a template
        echo $this->templates->render('homePage', ['comments' => $comments]);
    }

    public function login()
    {
        // Render a template
        echo $this->templates->render('loginPage', ['comments' => 'fuck']);
    }

    public function register()
    {
        // Render a template
        echo $this->templates->render('registerPage', ['comments' => 'fuck']);
    }

    public function registerUser()
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                $url = 'https://www.manilo.icu/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                $send = SimpleMail::make()
                    ->setTo($_POST['email'], $_POST['username'])
                    ->setFrom('manilo.83@mail.ru', 'Vitaliy Manilo')
                    ->setMessage($url)
                    ->send();
            });
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
        header("Location: /login");
        exit;
    }

    public function loginUser()
    {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        if ($_POST['remember'] == 'on') {
            $rememberDuration = (int)(60 * 60 * 24 * 365.25);
        } else {
            $rememberDuration = null;
        }
        $this->auth->login($_POST['email'], $_POST['password'], $rememberDuration);

        //тут надо получить имя автарки
        $db = new App\QueryBuilder();
        $string = $db->getString('users', $_SESSION['auth_user_id']);
        $_SESSION['user_photo'] = $string['user_photo'];
        header("Location: /");
        exit;
    }

    public function verify_email()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);

            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function logout()
    {
        $this->auth->logOut();
        header("Location: /");
        exit;
    }

    public function profile()
    {
        // Render a template
        echo $this->templates->render('profilePage', ['comments' => 'fuck']);
    }

    public function addComment()
    {
        $db = new App\QueryBuilder();
        $db->addComment();
        header("Location: /");
        exit;
    }

    public function updateUser()
    {
        if ($_POST['email'] != $_SESSION['auth_email']) {
            try {
                $this->auth->changeEmail($_POST['email'], function ($selector, $token) {
                    $url = 'https://www.manilo.icu/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                    $send = SimpleMail::make()
                        ->setTo($_POST['email'], $_POST['login'])
                        ->setFrom('manilo.83@mail.ru', 'Vitaliy Manilo')
                        ->setMessage($url)
                        ->send();
                });
            } catch (\Delight\Auth\InvalidEmailException $e) {
                die('Invalid email address');
            } catch (\Delight\Auth\UserAlreadyExistsException $e) {
                die('Email address already exists');
            } catch (\Delight\Auth\EmailNotVerifiedException $e) {
                die('Account not verified');
            } catch (\Delight\Auth\NotLoggedInException $e) {
                die('Not logged in');
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                die('Too many requests');
            }
        }

        $this->updateUserPhoto();
    }

    public function updateUserPhoto()
    {
        if ($_FILES['image']['name']) {
            $fileToDelite = $_SESSION['user_photo'];
            $name = $this->uploadImage($_FILES['image']);
            $db = new App\QueryBuilder();
            $data = [
                'user_photo' => $name,
            ];
            $db->update('users', $data, $_SESSION['auth_user_id']);

            if ($fileToDelite != 'user.jpg') {
                $path = '../images/' . $fileToDelite;
                unlink($path);
            }
            $_SESSION['user_photo'] = $name;
            header("Location: /profile");
            exit;
        } else//если новое фото не загружено, то обратно на страницу профиля
        {
            header("Location: /profile");
            exit;
        }
    }

    public function uploadImage($image)
    {
        $path = '../images';
        $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
        $filename = $this->getRandomFileName($path, $extension);
        $target = $path . '/' . $filename . '.' . $extension;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $name = $filename . '.' . $extension;
        return $name;
    }

    public function getRandomFileName($path, $extension = '')
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';
        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));
        return $name;
    }

    public function admin()
    {
        if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            if ($_SESSION['auth_logged_in']) {
                header("Location: /");
                exit;
            } else {
                header("Location: /login");
                exit;
            }
        }

        $db = new App\QueryBuilder();
        $comments = $db->getAllComments();

        // Render a template
        echo $this->templates->render('adminPage', ['comments' => $comments]);
    }

    public function changeAccessComment()
    {

        //из массива GET получаю id комментария и его состояние разрешен/не разрешен. Меняю состояние на противоположное
        $id = $_GET['id'];
        $access = $_GET['access'];
        $statement = $this->pdo->prepare("UPDATE `comments` SET `access` = :access WHERE `id` = :id");
        ($access == 1) ? $access = 0 : $access = 1;
        $values = ['access' => $access, 'id' => $id];
        $statement->execute($values);
        header('Location: admin');
        exit;
    }

    public function deleteComment()
    {
        $id = $_GET['id'];
        $query = $this->pdo->prepare("DELETE FROM `comments` WHERE `id` = :id");
        $values = ['id' => $id];
        $query->execute($values);
        header('Location: admin');
        exit;
    }

    public function updatePassword()
    {
        try {
            $this->auth->changePassword($_POST['oldPassword'], $_POST['newPassword']);

            header('Location: profile');
            exit;
        } catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in. Please, <a href="login">log in</a> or <a href="register">register</a>');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password(s). <a href="profile">try again</a>');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests. Try later. <a href="/">Main</a>');
        }
    }
}