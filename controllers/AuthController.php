<?php

use JetBrains\PhpStorm\NoReturn;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function login() {
        $postData = $this->retrievePostData();
        $user = $this->userModel->retrieveByAccount($postData['account']);
        if (isset($user['password']) && $user['password'] == $postData['password']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['identity'] = $user['identity'];
            $this->redirect('./?url=page/dashboard');
        } else {
            $this->redirect('./?url=page/login&error=1');
        }
    }

    #[NoReturn] public function logout() {
        session_destroy();
        $this->redirect('./?url=page/login');
        exit();
    }
}