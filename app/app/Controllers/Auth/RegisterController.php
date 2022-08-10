<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\{Auth\Auth, Auth\Hashing\Hasher, Controllers\Controller, Entities\User, Session\Flash, Views\View};
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response;
use League\Route\Router;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

class RegisterController extends Controller
{
    public function __construct(
        protected View $view,
        protected Auth $auth,
        protected Router $router,
        protected Flash $flash,
        protected Hasher $hash,
        protected EntityManager $db
    ) {
    }

    public function index(): ResponseInterface
    {
        return $this->view->render(new Response, 'auth/register.twig');
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $data = $this->validateRegistration($request);

        $this->createUser($data);

        $this->auth->attempt($data['email'], $data['password']);

        return redirect($this->router->getNamedRoute('home')->getPath());
    }

    protected function createUser(array $data): User
    {
        $user = new User();

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->hash->create($data['password'])
        ]);

        $this->db->persist($user);
        $this->db->flush();

        return $user;
    }

    private function validateRegistration(ServerRequestInterface $request): array
    {
        return $this->validate($request, [
            'email' => ['required', 'email', ['exists', User::class]],
            'name' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required', ['equals', 'password']]
        ]);
    }
}
