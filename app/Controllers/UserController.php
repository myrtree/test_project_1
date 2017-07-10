<?php

namespace Controllers;

use Simple\Storage;
use Services\UserService;

class UserController
{
    public function __construct()
    {
        $userService = new UserService;
        $view = Storage::get('view');
        $view->injectVars(['user' => $userService->getUser()]);

        // $userService->create('admin', 'admin@test.test', '123', true);
    }

    public function loginForm()
    {
        $view = Storage::get('view');
        return $view->render('login');
    }

    public function logIn()
    {
        $userService = new UserService;
        $view = Storage::get('view');

        $email = filter_input(INPUT_POST, 'email');
        if (strpos($email, '@') === false) {
            return $view->render('login', [
                'error' => 'Введите правильный email'
            ]);
        }

        $logedIn = $userService->logIn(
            filter_input(INPUT_POST, 'email'),
            filter_input(INPUT_POST, 'password')
        );

        if (!$logedIn) {
            return $view->render('login', [
                'error' => 'Введённые email или пароль не верны'
            ]);
        }

        header('Location: ?r=tasks');
    }

    public function logOut()
    {
        $userService = new UserService;
        $userService->logOut();

        header('Location: ?r=tasks');
    }
}
