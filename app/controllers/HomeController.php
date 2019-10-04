<?php

namespace App\controllers;

use App\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use PDO;
use SimpleMail;

class HomeController
{
    private $pdo;
    private $templates;
    private $auth;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=blog2;charset=utf8;', 'root', '');
        $this->templates = new Engine('../app/views');
        $this->auth = new Auth($this->pdo);
    }

    public function index($vars)
    {
        $db = new QueryBuilder();
        $comments = $db->getAll('comments');

        $_SESSION['role'] = $this->auth->getRoles();

        echo $this->templates->render('profile', ['comments' => $comments]);

    }

    public function registerpage()
    {
        echo $this->templates->render('registerpage', ['comments' => $comments]);
    }

    public function registerUser()
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                $send = SimpleMail::make()
                    ->setTo($_POST['email'], $_POST['username'])
                    ->setFrom('manilo.83@mail.ru', 'Manilo')
                    ->setSubject('Тема')
                    ->setMessage($url = 'https://www.example.com/emailVerification?selector=' . \urlencode($selector) . '&token=' . \urlencode($token))
                    ->send();

                echo ($send) ? 'Email sent successfully' : 'Could not send email';
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

    }

    public function loginpage()
    {
        echo $this->templates->render('loginpage', ['comments' => $comments]);
    }

    public function loginUser()
    {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);

            header("Location: users");
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function emailVerification()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function logout()
    {
        $this->auth->logOut();
        header("Location: users");
    }

    public function userPage()
    {
        echo $this->templates->render('userPage', ['comments' => $comments]);
    }

}