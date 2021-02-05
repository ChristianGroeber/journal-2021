<?php

namespace Nacho\Controllers;

class AuthenticationController extends AbstractController
{
    public function login($request)
    {
        if (!isset($_REQUEST['required_page'])) {
            $_REQUEST['required_page'] = '/';
        }
        $message = '';
        if (strtolower($request->requestMethod) === 'post') {
            $isValid = false;
            $foundUser = null;
            foreach ($this->nacho->userHandler->getUsers() as $user) {
                if (
                    $user['username'] === $_REQUEST['username'] &&
                    password_verify($_REQUEST['password'], $user['password'])
                ) {
                    $isValid = true;
                    $foundUser = $user;
                    break;
                }
            }

            if (!$isValid) {
                $message = 'This password/ username is not valid';
                header('HTTP/1.0 400');
            } else {
                session_start();
                $_SESSION['user'] = $foundUser;
                header('HTTP/1.1 302');
                header('Location: ' . $_REQUEST['required_page']);
                die();
            }
        }

        return $this->render('security/login.twig', [
            'message' => $message,
            'page' => $_REQUEST['required_page'],
        ]);
    }

    public function logout($request)
    {
        session_destroy();
        header('HTTP/1.1 302');
        header('Location: /');
    }

    public function register($request)
    {
        if (strtolower($request->requestMethod) === 'post') {
            $existingUsers = json_decode(
                file_get_contents($request->documentRoot . '/users.json'),
                true
            );
            $userExists = false;
            foreach ($existingUsers as $user) {
                if ($user['username'] === $_REQUEST['username']) {
                    header('HTTP/1.0 409');
                    $message = 'This username is already taken';
                    $userExists = true;
                    break;
                }
            }
            if (!$userExists) {
                array_push($existingUsers, [
                    'username' => $_REQUEST['username'],
                    'password' => password_hash($_REQUEST['password'], PASSWORD_DEFAULT),
                    'role' => 'Reader',
                ]);
                print_r($existingUsers);
                file_put_contents(
                    $request->documentRoot . 'users.json',
                    json_encode($existingUsers)
                );

                header('HTTP/1.1 302');
                header('Location: /');
                return '';
            }
        }

        return $this->render(VIEWS_DIR . '/base.php', [
            'article' => $this->render(
                VIEWS_DIR . '/includes/security/register/article.php'
            ),
        ]);
    }
}
