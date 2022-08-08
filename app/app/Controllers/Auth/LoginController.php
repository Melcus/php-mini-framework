<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Controllers\Controller;
use App\Views\View;
use Laminas\Diactoros\Response;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginController extends Controller
{
    public function __construct(
        protected View $view,
        protected Auth $auth,
        protected Router $router
    ) {
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'auth/login.twig');
    }

    public function store(ServerRequestInterface $request)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = $this->auth->attempt($data['email'], $data['password']);

        if (!$attempt) {
            // todo: implement flashing
            dd('failed');
        }

        return redirect($this->router->getNamedRoute('home')->getPath());
    }
}